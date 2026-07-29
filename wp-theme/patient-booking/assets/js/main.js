/**
 * Patient Booking Landing — interactions + analytics
 * Works with GA4 (gtag) and/or GTM (dataLayer)
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

  /* ---------- Reveal on scroll ---------- */
  var revealEls = document.querySelectorAll(".reveal, .service-tile, .testimonial-card, .service-item, .testimonial, .stat-item");
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
      { threshold: 0.18, rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach(function (el) {
      io.observe(el);
    });
  } else {
    revealEls.forEach(function (el) {
      el.classList.add("is-in");
    });
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
  window.addEventListener(
    "scroll",
    function () {
      if (scrollTick) return;
      scrollTick = true;
      window.requestAnimationFrame(function () {
        onScrollDepth();
        scrollTick = false;
      });
    },
    { passive: true }
  );

  /* ---------- Phone + CTA clicks ---------- */
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

  /* Social click tracking */
  document.querySelectorAll("[data-social]").forEach(function (link) {
    link.addEventListener("click", function () {
      pushEvent("social_click", {
        social_network: link.getAttribute("data-social"),
        link_url: link.getAttribute("href")
      });
    });
  });

  /* ---------- Forms (mobile + desktop may both exist; wire each) ---------- */
  var forms = document.querySelectorAll("[data-booking-form]");
  var formStarted = false;

  forms.forEach(function (form) {
    var status = form.querySelector("[data-form-status]");
    var fields = {
      name: form.querySelector('[name="full_name"]'),
      phone: form.querySelector('[name="phone"]'),
      email: form.querySelector('[name="email"]'),
      treatment: form.querySelector('[name="treatment"]'),
      preferred_time: form.querySelector('[name="preferred_time"]')
    };

    function clearErrors() {
      form.querySelectorAll(".is-invalid").forEach(function (el) {
        el.classList.remove("is-invalid");
      });
      form.querySelectorAll(".field-error").forEach(function (el) {
        el.classList.remove("show");
        el.textContent = "";
      });
      if (status) {
        status.className = "form-status";
        status.textContent = "";
      }
    }

    function showFieldError(input, message) {
      if (!input) return;
      input.classList.add("is-invalid");
      var err = input.parentElement.querySelector(".field-error");
      if (err) {
        err.textContent = message;
        err.classList.add("show");
      }
    }

    function validEmail(v) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    function validPhone(v) {
      var digits = (v || "").replace(/\D/g, "");
      return digits.length >= 10;
    }

    function readValues() {
      return {
        full_name: (fields.name && fields.name.value || "").trim(),
        phone: (fields.phone && fields.phone.value || "").trim(),
        email: (fields.email && fields.email.value || "").trim(),
        treatment: fields.treatment && fields.treatment.value || "",
        preferred_time: fields.preferred_time && fields.preferred_time.value || ""
      };
    }

    function savePartial() {
      var data = readValues();
      if (!data.full_name && !data.phone) return;
      try {
        localStorage.setItem(
          PARTIAL_KEY,
          JSON.stringify(Object.assign({ saved_at: Date.now() }, data))
        );
      } catch (e) { /* ignore */ }

      if (data.full_name && data.phone) {
        pushEvent("partial_lead", {
          has_name: true,
          has_phone: true,
          treatment: data.treatment || "(none)"
        });
      }
    }

    function restorePartial() {
      try {
        var raw = localStorage.getItem(PARTIAL_KEY);
        if (!raw) return;
        var data = JSON.parse(raw);
        if (fields.name && !fields.name.value && data.full_name) fields.name.value = data.full_name;
        if (fields.phone && !fields.phone.value && data.phone) fields.phone.value = data.phone;
        if (fields.email && !fields.email.value && data.email) fields.email.value = data.email;
        if (fields.treatment && !fields.treatment.value && data.treatment) fields.treatment.value = data.treatment;
        if (fields.preferred_time && !fields.preferred_time.value && data.preferred_time) {
          fields.preferred_time.value = data.preferred_time;
        }
      } catch (e) { /* ignore */ }
    }

    restorePartial();

    form.addEventListener(
      "focusin",
      function () {
        if (!formStarted) {
          formStarted = true;
          pushEvent("form_start", { form_id: "booking" });
        }
      },
      true
    );

    ["change", "blur"].forEach(function (evt) {
      form.addEventListener(evt, function (e) {
        if (e.target && e.target.matches("input, select")) savePartial();
      }, true);
    });

    window.addEventListener("pagehide", savePartial);

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      clearErrors();
      var data = readValues();
      var ok = true;

      if (!data.full_name || data.full_name.length < 2) {
        showFieldError(fields.name, "Please enter your full name.");
        ok = false;
      }
      if (!validPhone(data.phone)) {
        showFieldError(fields.phone, "Enter a valid mobile number.");
        ok = false;
      }
      if (!validEmail(data.email)) {
        showFieldError(fields.email, "Enter a valid email address.");
        ok = false;
      }
      if (!data.treatment) {
        showFieldError(fields.treatment, "Select a treatment interest.");
        ok = false;
      }
      if (!data.preferred_time) {
        showFieldError(fields.preferred_time, "Select a preferred time.");
        ok = false;
      }

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

      function onSuccess() {
        try { localStorage.removeItem(PARTIAL_KEY); } catch (e) { /* ignore */ }
        pushEvent("generate_lead", {
          form_id: "booking",
          treatment: data.treatment,
          preferred_time: data.preferred_time
        });
        pushEvent("form_submit", {
          form_id: "booking",
          treatment: data.treatment
        });
        if (status) {
          status.className = "form-status is-success";
          status.textContent = "You’re on our list. A team member will confirm your chair shortly.";
        }
        form.reset();
      }

      function onFail() {
        if (status) {
          status.className = "form-status is-error";
          status.textContent = "Something went wrong. Please call us and we’ll book you in.";
        }
      }

      /* Hook: replace endpoint with your scheduling/CRM webhook or WP admin-ajax URL */
      if (!endpoint) {
        console.info("[Booking] Demo submit — set data-endpoint to your scheduling software webhook.", payload);
        onSuccess();
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
        .then(onSuccess)
        .catch(onFail);
    });
  });

  /* ---------- Contact form ---------- */
  document.querySelectorAll("[data-contact-form]").forEach(function (form) {
    var status = form.querySelector("[data-form-status]");
    var nameEl = form.querySelector('[name="full_name"]');
    var emailEl = form.querySelector('[name="email"]');
    var phoneEl = form.querySelector('[name="phone"]');
    var messageEl = form.querySelector('[name="message"]');
    var started = false;

    form.addEventListener("focusin", function () {
      if (!started) {
        started = true;
        pushEvent("form_start", { form_id: "contact" });
      }
    }, true);

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      form.querySelectorAll(".is-invalid").forEach(function (el) { el.classList.remove("is-invalid"); });
      form.querySelectorAll(".field-error").forEach(function (el) {
        el.classList.remove("show");
        el.textContent = "";
      });
      if (status) {
        status.className = "form-status";
        status.textContent = "";
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

      var data = {
        full_name: (nameEl && nameEl.value || "").trim(),
        email: (emailEl && emailEl.value || "").trim(),
        phone: (phoneEl && phoneEl.value || "").trim(),
        message: (messageEl && messageEl.value || "").trim()
      };
      var ok = true;
      if (data.full_name.length < 2) { showErr(nameEl, "Please enter your full name."); ok = false; }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) { showErr(emailEl, "Enter a valid email."); ok = false; }
      if ((data.phone.replace(/\D/g, "")).length < 10) { showErr(phoneEl, "Enter a valid phone number."); ok = false; }
      if (data.message.length < 5) { showErr(messageEl, "Please add a short message."); ok = false; }

      if (!ok) {
        if (status) {
          status.className = "form-status is-error";
          status.textContent = "Please check the highlighted fields and try again.";
        }
        return;
      }

      var endpoint = form.getAttribute("data-endpoint") || "";
      var payload = Object.assign({}, data, { source: "contact_form", page: window.location.pathname });

      function success() {
        pushEvent("generate_lead", { form_id: "contact" });
        pushEvent("form_submit", { form_id: "contact" });
        if (status) {
          status.className = "form-status is-success";
          status.textContent = "Thanks — we’ll get back to you shortly.";
        }
        form.reset();
      }

      if (!endpoint) {
        console.info("[Contact] Demo submit — set data-endpoint for production.", payload);
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
