/**
 * Patient Booking Landing — interactions + analytics
 */
(function () {
  "use strict";

  var PARTIAL_KEY = "pb_partial_lead";

  function pushEvent(name, params) {
    params = params || {};
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(Object.assign({ event: name }, params));
    if (typeof window.gtag === "function") {
      window.gtag("event", name, params);
    }
  }

  /* ---------- Mobile nav ---------- */
  var toggle = document.querySelector("[data-nav-toggle]");
  var nav = document.querySelector("[data-primary-nav]");
  var backdrop = document.querySelector("[data-nav-backdrop]");

  function setNav(open) {
    if (!toggle || !nav) return;
    toggle.setAttribute("aria-expanded", open ? "true" : "false");
    nav.classList.toggle("is-open", open);
    document.body.classList.toggle("nav-open", open);
    if (backdrop) {
      if (open) backdrop.removeAttribute("hidden");
      else backdrop.setAttribute("hidden", "");
    }
  }

  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      setNav(toggle.getAttribute("aria-expanded") !== "true");
    });
    if (backdrop) {
      backdrop.addEventListener("click", function () { setNav(false); });
    }
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () { setNav(false); });
    });
  }

  /* ---------- Reveal on scroll ---------- */
  var revealEls = document.querySelectorAll(".reveal, .service-tile, .testimonial-card, .stat-item, .team-card, .result-card, .video-card, .resource-card");
  if ("IntersectionObserver" in window) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-in");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.16, rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add("is-in"); });
  }

  /* ---------- Scroll depth ---------- */
  var depths = [25, 50, 75, 90];
  var fired = {};
  function onScrollDepth() {
    var doc = document.documentElement;
    var scrollTop = window.scrollY || doc.scrollTop;
    var height = doc.scrollHeight - window.innerHeight;
    if (height <= 0) return;
    var pct = Math.round((scrollTop / height) * 100);
    depths.forEach(function (d) {
      if (pct >= d && !fired[d]) {
        fired[d] = true;
        pushEvent("scroll_depth", { percent_scrolled: d });
      }
    });
  }
  var scrollTick = false;
  window.addEventListener("scroll", function () {
    if (scrollTick) return;
    scrollTick = true;
    window.requestAnimationFrame(function () {
      onScrollDepth();
      scrollTick = false;
    });
  }, { passive: true });

  /* ---------- Clicks ---------- */
  document.querySelectorAll('a[href^="tel:"]').forEach(function (link) {
    link.addEventListener("click", function () {
      pushEvent("phone_click", {
        link_url: link.getAttribute("href"),
        link_text: (link.textContent || "").trim()
      });
    });
  });

  document.querySelectorAll("[data-track-cta]").forEach(function (el) {
    el.addEventListener("click", function () {
      pushEvent("cta_click", {
        cta_id: el.getAttribute("data-track-cta"),
        cta_text: (el.textContent || "").trim()
      });
    });
  });

  document.querySelectorAll("[data-social]").forEach(function (link) {
    link.addEventListener("click", function () {
      pushEvent("social_click", {
        social_network: link.getAttribute("data-social"),
        link_url: link.getAttribute("href")
      });
    });
  });

  /* ---------- Success modal ---------- */
  var modal = document.querySelector("[data-success-modal]");
  function showSuccess() {
    if (!modal) return;
    modal.removeAttribute("hidden");
    document.body.classList.add("nav-open");
  }
  function hideSuccess() {
    if (!modal) return;
    modal.setAttribute("hidden", "");
    document.body.classList.remove("nav-open");
  }
  if (modal) {
    var closeBtn = modal.querySelector("[data-success-close]");
    if (closeBtn) closeBtn.addEventListener("click", hideSuccess);
    modal.addEventListener("click", function (e) {
      if (e.target === modal) hideSuccess();
    });
  }

  /* ---------- Video modal ---------- */
  var videoModal = document.querySelector("[data-video-modal]");
  var videoFrame = document.querySelector("[data-video-frame]");
  function openVideo(url) {
    if (!videoModal || !videoFrame) return;
    videoFrame.innerHTML = '<iframe src="' + url + '?autoplay=1" title="Patient story" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    videoModal.removeAttribute("hidden");
    document.body.style.overflow = "hidden";
  }
  function closeVideo() {
    if (!videoModal || !videoFrame) return;
    videoFrame.innerHTML = "";
    videoModal.setAttribute("hidden", "");
    document.body.style.overflow = "";
  }
  document.querySelectorAll("[data-video]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      openVideo(btn.getAttribute("data-video"));
      pushEvent("video_play", { video_url: btn.getAttribute("data-video") });
    });
  });
  if (videoModal) {
    var vClose = videoModal.querySelector("[data-video-close]");
    if (vClose) vClose.addEventListener("click", closeVideo);
    videoModal.addEventListener("click", function (e) {
      if (e.target === videoModal) closeVideo();
    });
  }
  document.addEventListener("keydown", function (e) {
    if (e.key !== "Escape") return;
    if (videoModal && !videoModal.hasAttribute("hidden")) closeVideo();
    if (modal && !modal.hasAttribute("hidden")) hideSuccess();
  });

  /* ---------- Live availability widget ---------- */
  var slotsByDay = {
    Tue: ["9:00 AM", "10:30 AM", "1:00 PM", "3:30 PM"],
    Wed: ["8:30 AM", "11:00 AM", "2:00 PM", "4:00 PM"],
    Thu: ["9:30 AM", "12:00 PM", "2:30 PM", "5:00 PM"],
    Fri: ["8:00 AM", "10:00 AM", "1:30 PM", "3:00 PM"],
    Sat: ["9:00 AM", "11:30 AM", "1:00 PM"]
  };
  var takenMap = { Tue: ["10:30 AM"], Wed: ["4:00 PM"], Fri: ["8:00 AM"] };
  var availRoot = document.querySelector("[data-availability]");
  if (availRoot) {
    var slotsEl = availRoot.querySelector("[data-availability-slots]");
    var updatedEl = availRoot.querySelector("[data-availability-updated]");
    var activeDay = "Tue";

    function mapSlotToPreferred(label) {
      var hour = parseInt(label, 10);
      var isPm = /PM/i.test(label);
      var h24 = isPm ? (hour === 12 ? 12 : hour + 12) : (hour === 12 ? 0 : hour);
      if (h24 < 12) return "mornings";
      if (h24 < 17) return "afternoons";
      return "evenings";
    }

    function renderSlots(day) {
      if (!slotsEl) return;
      slotsEl.innerHTML = "";
      (slotsByDay[day] || []).forEach(function (label) {
        var btn = document.createElement("button");
        btn.type = "button";
        btn.className = "availability-slot";
        btn.textContent = label;
        var taken = (takenMap[day] || []).indexOf(label) !== -1;
        if (taken) {
          btn.classList.add("is-taken");
          btn.disabled = true;
        } else {
          btn.addEventListener("click", function () {
            slotsEl.querySelectorAll(".availability-slot").forEach(function (b) {
              b.classList.remove("is-selected");
            });
            btn.classList.add("is-selected");
            var preferred = mapSlotToPreferred(label);
            var select = document.querySelector('#preferred_time, [name="preferred_time"]');
            if (select) select.value = preferred;
            pushEvent("availability_select", { day: day, time: label, preferred_time: preferred });
            var contact = document.getElementById("contact");
            if (contact) contact.scrollIntoView({ behavior: "smooth", block: "start" });
          });
        }
        slotsEl.appendChild(btn);
      });
    }

    availRoot.querySelectorAll("[data-day]").forEach(function (tab) {
      tab.addEventListener("click", function () {
        activeDay = tab.getAttribute("data-day");
        availRoot.querySelectorAll("[data-day]").forEach(function (t) {
          t.classList.toggle("is-active", t === tab);
          t.setAttribute("aria-selected", t === tab ? "true" : "false");
        });
        renderSlots(activeDay);
      });
    });

    renderSlots(activeDay);
    if (updatedEl) {
      setInterval(function () {
        updatedEl.textContent = "Live · updated " + new Date().toLocaleTimeString([], { hour: "numeric", minute: "2-digit" });
      }, 60000);
    }
  }

  /* ---------- Contact / booking form (3 fields) ---------- */
  document.querySelectorAll("[data-contact-form]").forEach(function (form) {
    var status = form.querySelector("[data-form-status]");
    var nameEl = form.querySelector('[name="full_name"]');
    var phoneEl = form.querySelector('[name="phone"]');
    var timeEl = form.querySelector('[name="preferred_time"]');
    var started = false;

    function clearErrors() {
      form.querySelectorAll(".is-invalid").forEach(function (el) { el.classList.remove("is-invalid"); });
      form.querySelectorAll(".field-error").forEach(function (el) {
        el.classList.remove("show");
        el.textContent = "";
      });
      if (status) {
        status.className = "form-status";
        status.textContent = "";
      }
    }

    function showErr(input, msg) {
      if (!input) return;
      input.classList.add("is-invalid");
      var err = input.parentElement.querySelector(".field-error");
      if (err) {
        err.textContent = msg;
        err.classList.add("show");
      }
    }

    function savePartial() {
      var data = {
        full_name: (nameEl && nameEl.value || "").trim(),
        phone: (phoneEl && phoneEl.value || "").trim(),
        preferred_time: timeEl && timeEl.value || ""
      };
      if (!data.full_name && !data.phone) return;
      try {
        localStorage.setItem(PARTIAL_KEY, JSON.stringify(Object.assign({ saved_at: Date.now() }, data)));
      } catch (e) { /* ignore */ }
      if (data.full_name && data.phone) {
        pushEvent("partial_lead", { has_name: true, has_phone: true });
      }
    }

    try {
      var raw = localStorage.getItem(PARTIAL_KEY);
      if (raw) {
        var saved = JSON.parse(raw);
        if (nameEl && !nameEl.value && saved.full_name) nameEl.value = saved.full_name;
        if (phoneEl && !phoneEl.value && saved.phone) phoneEl.value = saved.phone;
        if (timeEl && !timeEl.value && saved.preferred_time) timeEl.value = saved.preferred_time;
      }
    } catch (e) { /* ignore */ }

    form.addEventListener("focusin", function () {
      if (!started) {
        started = true;
        pushEvent("form_start", { form_id: "contact" });
      }
    }, true);

    ["change", "blur"].forEach(function (evt) {
      form.addEventListener(evt, function (e) {
        if (e.target && e.target.matches("input, select")) savePartial();
      }, true);
    });
    window.addEventListener("pagehide", savePartial);

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      clearErrors();

      var data = {
        full_name: (nameEl && nameEl.value || "").trim(),
        phone: (phoneEl && phoneEl.value || "").trim(),
        preferred_time: timeEl && timeEl.value || ""
      };
      var ok = true;
      if (data.full_name.length < 2) { showErr(nameEl, "Please enter your full name."); ok = false; }
      if ((data.phone.replace(/\D/g, "")).length < 10) { showErr(phoneEl, "Enter a valid mobile number."); ok = false; }
      if (!data.preferred_time) { showErr(timeEl, "Select a preferred time."); ok = false; }

      if (!ok) {
        if (status) {
          status.className = "form-status is-error";
          status.textContent = "Please check the highlighted fields and try again.";
        }
        return;
      }

      var endpoint = form.getAttribute("data-endpoint") || "";
      var payload = Object.assign({}, data, {
        source: "landing_booking",
        page: window.location.pathname
      });

      function success() {
        try { localStorage.removeItem(PARTIAL_KEY); } catch (err) { /* ignore */ }
        pushEvent("generate_lead", {
          form_id: "contact",
          preferred_time: data.preferred_time
        });
        pushEvent("form_submit", { form_id: "contact" });
        if (status) {
          status.className = "form-status is-success";
          status.textContent = "Request received — check the confirmation popup.";
        }
        form.reset();
        showSuccess();
      }

      if (!endpoint) {
        console.info("[Booking] Demo submit", payload);
        success();
        return;
      }

      fetch(endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify(payload),
        credentials: "same-origin"
      })
        .then(function (res) {
          if (!res.ok) throw new Error("bad status");
          return res.json().catch(function () { return {}; });
        })
        .then(success)
        .catch(function () {
          if (status) {
            status.className = "form-status is-error";
            status.textContent = "Something went wrong. Please call us instead.";
          }
        });
    });
  });
})();
