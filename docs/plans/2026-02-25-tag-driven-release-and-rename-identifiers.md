# Tag-driven GitHub Release (ZIP) + Rename Identifiers Implementation Plan

> **REQUIRED SUB-SKILL:** Use the executing-plans skill to implement this plan task-by-task.

**Goal:** Stop committing build ZIPs in the repo and instead publish a ZIP asset via GitHub Releases on tag push; also rename all legacy `jetreviews-bricks-bridge` identifiers to the new `jetreviews-integration-bricks` (while keeping the ZIP folder name `jet-reviews-integration-for-bricks/`).

**Architecture:** Add a GitHub Actions workflow triggered by tags `v*` that builds a clean plugin folder and uploads the ZIP to a GitHub Release. Refactor plugin constants, slugs, text domain, namespaces, and option keys to the new identifier; keep backward compatibility by reading the old option key as fallback.

**Tech Stack:** WordPress plugin (PHP), GitHub Actions, bash (rsync/zip).

---

### Task 1: Remove committed build ZIP from git (clean repo)

**Files:**
- Modify: `jet-reviews-integration-for-bricks-0.1.6.zip` (remove from git)
- Modify: `.gitignore`

**Step 1: Remove file from git tracking**

Run:
```bash
git rm -f jet-reviews-integration-for-bricks-0.1.6.zip
```
Expected: file removed from index.

**Step 2: Add ignore rule for future ZIPs**

Edit `.gitignore` to include patterns like:
```gitignore
*.zip
/build/
.DS_Store
```

**Step 3: Commit**

```bash
git add .gitignore
git commit -m "chore: remove committed build zip and ignore artifacts"
```

---

### Task 2: Rename legacy identifiers in plugin code (with backward compatibility)

**Files:**
- Modify: `jet-reviews-integration-for-bricks.php`
- Modify: `includes/bricks/elements/reviews-listing.php`
- Modify: `includes/bricks/elements/static-review.php`
- Modify: `README.md`

**Step 1: Define target names**

- New slug/text-domain/prefix: `jetreviews-integration-bricks`
- Keep ZIP folder name: `jet-reviews-integration-for-bricks/`

**Step 2: Update plugin header + constants**

In `jet-reviews-integration-for-bricks.php`:
- `Text Domain:` -> `jetreviews-integration-bricks`
- `const SLUG` -> `jetreviews-integration-bricks`
- Rename class `JetReviews_Bricks_Bridge` -> `JetReviews_Integration_Bricks` (or similar consistent mapping)

**Step 3: Update option key with fallback**

- New option key: `jrb_enabled` (or `jrib_enabled`) — choose one and apply consistently.
- Read old `jrbbr_enabled` as fallback if new key not set.

**Step 4: Update namespaces in element files**

- `namespace JetReviews_Bricks_Bridge\Elements;` -> `namespace JetReviews_Integration_Bricks\Elements;`

**Step 5: Update any hard-coded log prefixes**

- `[JetReviews_Bricks_Bridge]` -> `[JetReviews_Integration_Bricks]`

**Step 6: Update README references**

- Replace `jetreviews-bricks-bridge` mention(s) with `jetreviews-integration-bricks`.

**Step 7: Sanity checks**

Run:
```bash
php -l jet-reviews-integration-for-bricks.php
php -l includes/bricks/elements/reviews-listing.php
php -l includes/bricks/elements/static-review.php
```
Expected: `No syntax errors detected` for each.

**Step 8: Commit**

```bash
git add jet-reviews-integration-for-bricks.php includes/bricks/elements README.md
git commit -m "refactor: rename bridge identifiers to jetreviews-integration-bricks"
```

---

### Task 3: Add tag-driven GitHub Actions workflow to build ZIP and publish Release

**Files:**
- Create: `.github/workflows/release.yml`

**Step 1: Create workflow**

Workflow requirements:
- Trigger: `on: push: tags: ['v*']`
- Determine `VERSION` from tag (strip leading `v`).
- Build dir: `build/jet-reviews-integration-for-bricks/`
- Copy source into build dir while excluding:
  - `.git/`, `.github/`, `.pi/`, `docs/`, `build/`, `*.zip`, `.DS_Store`
- Create ZIP: `jet-reviews-integration-for-bricks-${VERSION}.zip`
- Create GitHub Release + upload asset.

**Step 2: Commit**

```bash
git add .github/workflows/release.yml
git commit -m "ci: publish plugin zip to GitHub Releases on tag"
```

---

### Task 4: Verification (local) + how to release

**Step 1: Local check for unintended legacy strings**

Run:
```bash
rg -n "jetreviews-bricks-bridge|JetReviews_Bricks_Bridge|jrbbr_" -S .
```
Expected: no matches (except possibly in changelog/history if kept).

**Step 2: Release procedure**

```bash
# bump version in plugin header + constant
# then:
git tag vX.Y.Z
git push origin main --tags
```
Expected: GitHub Actions runs, creates a Release `vX.Y.Z`, and attaches `jet-reviews-integration-for-bricks-X.Y.Z.zip`.
