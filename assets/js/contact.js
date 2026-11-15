document.addEventListener("DOMContentLoaded", () => {
  /* ---------- FAQ accordion ---------- */
  const faqItems = document.querySelectorAll(".ct-faq-item");

  const setFaq = (item, open) => {
    const button = item.querySelector(".ct-faq-question");
    const panel = item.querySelector(".ct-faq-answer");
    item.classList.toggle("active", open);
    button.setAttribute("aria-expanded", open ? "true" : "false");
    panel.style.maxHeight = open ? panel.scrollHeight + "px" : "0px";
  };

  faqItems.forEach((item) => {
    item.querySelector(".ct-faq-question").addEventListener("click", () => {
      const willOpen = !item.classList.contains("active");
      faqItems.forEach((i) => setFaq(i, i === item && willOpen));
    });
  });

  window.addEventListener("resize", () => {
    faqItems.forEach((i) => {
      if (i.classList.contains("active")) setFaq(i, true);
    });
  });

  /* ---------- Contact form ---------- */
  const form = document.getElementById("contactForm");
  if (!form) return;

  const status = document.getElementById("ctStatus");
  const success = document.getElementById("ctSuccess");
  const submitBtn = document.getElementById("ctSubmit");
  const submitLabel = form.querySelector(".ct-submit-label");
  const another = document.getElementById("ctAnother");
  const card = document.getElementById("enquire");

  const wrapOf = (name) => form.querySelector('[data-field="' + name + '"]');

  const setError = (name, message) => {
    const wrap = wrapOf(name);
    if (!wrap) return;
    const target = wrap.querySelector(".ct-error");
    const control = wrap.querySelector("input, select, textarea");
    wrap.classList.toggle("is-invalid", !!message);
    if (target) target.textContent = message || "";
    if (control)
      control.setAttribute("aria-invalid", message ? "true" : "false");
  };

  const focusField = (name) => {
    const wrap = wrapOf(name);
    if (!wrap) return;
    const control =
      wrap.querySelector("input:checked") ||
      wrap.querySelector("input, select, textarea");
    if (control) control.focus();
  };

  const showStatus = (message) => {
    status.textContent = message || "";
    status.classList.toggle("is-error", !!message);
  };

  /* Client-side checks (the server re-validates everything) */
  const checks = {
    topic: () =>
      form.querySelector('input[name="topic"]:checked')
        ? ""
        : "Please choose a topic.",
    name: () =>
      form.elements.name.value.trim().length >= 2
        ? ""
        : "Please enter your full name.",
    email: () => {
      const el = form.elements.email;
      return el.value.trim() !== "" && el.checkValidity()
        ? ""
        : "Please enter a valid email address.";
    },
    phone: () => {
      const v = form.elements.phone.value.trim();
      return v === "" || /^[0-9+()\-\s]{6,20}$/.test(v)
        ? ""
        : "Please enter a valid phone number.";
    },
    message: () =>
      form.elements.message.value.trim().length >= 10
        ? ""
        : "Please tell us a little more (at least 10 characters).",
    consent: () =>
      form.elements.consent.checked
        ? ""
        : "Please confirm that we can contact you about your enquiry.",
  };

  const validate = () => {
    let first = null;
    Object.keys(checks).forEach((name) => {
      const message = checks[name]();
      setError(name, message);
      if (message && !first) first = name;
    });
    return first;
  };

  const clearOnEdit = (e) => {
    const wrap = e.target.closest("[data-field]");
    if (wrap) setError(wrap.dataset.field, "");
    showStatus("");
  };
  form.addEventListener("input", clearOnEdit);
  form.addEventListener("change", clearOnEdit);

  const setBusy = (busy) => {
    submitBtn.disabled = busy;
    submitLabel.textContent = busy ? "Sending…" : "Send message";
  };

  const showSuccess = () => {
    form.hidden = true;
    success.hidden = false;
    card.scrollIntoView({ behavior: "smooth", block: "start" });
    success.querySelector("h2").focus({ preventScroll: true });
  };

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    showStatus("");

    const firstInvalid = validate();
    if (firstInvalid) {
      focusField(firstInvalid);
      return;
    }

    setBusy(true);
    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        credentials: "same-origin",
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      });
      const data = await response.json();

      if (data.ok) {
        showSuccess();
        return;
      }

      const fieldErrors = data.errors || {};
      Object.keys(fieldErrors).forEach((name) =>
        setError(name, fieldErrors[name]),
      );
      showStatus(
        data.message || "Please check the highlighted fields and try again.",
      );
      const first = Object.keys(fieldErrors)[0];
      if (first) focusField(first);
    } catch (err) {
      showStatus(
        "Something went wrong sending your message. Please try again, or email info@cornell.vic.edu.au or call 1300 195 612.",
      );
    } finally {
      setBusy(false);
    }
  });

  /* "Send another" – reset and show the form again */
  if (another) {
    another.addEventListener("click", () => {
      form.reset();
      Object.keys(checks).forEach((name) => setError(name, ""));
      showStatus("");
      success.hidden = true;
      form.hidden = false;
      card.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  }
});
