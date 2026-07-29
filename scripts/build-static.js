const fs = require("fs");
const path = require("path");

const root = path.join(__dirname, "..");
const src = path.join(root, "preview");
const dest = path.join(root, "public");

function rimraf(dir) {
  if (!fs.existsSync(dir)) return;
  fs.rmSync(dir, { recursive: true, force: true });
}

function copyRecursive(from, to) {
  const stat = fs.statSync(from);
  if (stat.isDirectory()) {
    fs.mkdirSync(to, { recursive: true });
    for (const entry of fs.readdirSync(from)) {
      if (entry === "vercel.json") continue;
      copyRecursive(path.join(from, entry), path.join(to, entry));
    }
    return;
  }
  fs.copyFileSync(from, to);
}

rimraf(dest);
fs.mkdirSync(dest, { recursive: true });
copyRecursive(src, dest);
console.log("Static site copied preview/ → public/");
