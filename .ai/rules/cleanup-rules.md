# 🧠 AI CLEANUP RULES — SAFE DUPLICATE REMOVAL

> Location: `/cloudfold/.ai/rules/cleanup-rules.md`
> Goal: Duplicate code remove করা WITHOUT breaking functionality

---

## 🚨 CORE PRINCIPLES

* NEVER break working features
* DO NOT delete without verification
* Refactor > Delete
* Preserve WordPress lifecycle
* Respect dependency chain
* Work incrementally (file-by-file)

---

## 🔍 DUPLICATE TYPES

### Function Duplicate

* Same logic different name
* Same function defined multiple times

### Class Duplicate

* Same responsibility class
* Overlapping methods

### Logic Duplicate

* Same condition / calculation repeated

### UI Duplicate

* Same JSX / HTML block repeated

### Style Duplicate

* Same Tailwind / CSS patterns repeated

### API Duplicate

* Same endpoint / fetch config repeated

---

## ⚙️ SAFE REFACTOR STRATEGY

Rule: Extract → Replace → Verify

1. Extract shared logic
2. Replace all usages
3. Verify before delete

---

## 🔗 DEPENDENCY CHECK (CRITICAL)

Before removing ANY code:

Check:

* Used in add_action / add_filter?
* Used in AJAX?
* Used in REST API?
* Dynamically referenced?

If unsure:
→ DO NOT REMOVE
→ Mark as REVIEW REQUIRED

---

## 🧠 NAMING STANDARD

```
nodex_{module}_{action}
```

---

## 🧱 STRUCTURE

```
/core
/helpers
/services
/hooks
/modules
/components
```

---

## ⚠️ DO NOT TOUCH

* Freemius SDK
* License logic
* Nonce / sanitize
* DB schema
* Bootstrap/init

---

## 🧪 VALIDATION

After every change:

* No undefined functions
* No missing imports
* Hooks working
* AJAX working
* No console errors
* No PHP warnings

---

## 🚀 EXECUTION MODE

* ONE FILE at a time
* Replace usage FIRST
* THEN remove duplicate

---

## 📤 OUTPUT FORMAT

```diff
--- BEFORE
+++ AFTER
```

OR full updated file

---

## 🔒 SAFETY MODE

If confidence < 100%:
→ REVIEW REQUIRED

---

## 🎯 GOAL

✔ Clean code
✔ Zero duplicate logic
✔ No regression

---

END
