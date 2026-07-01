# あけみんゴルフ — Akemin Golf

A trilingual (日本語 / English / 中文) brand site for **光本朱見 (Akemi Mitsumoto)**, founder of
**ハリジェンヌ / Harisienne** — built around her mission to connect friends across the world
through golf, beauty and health, and to become a *Global Grandmother*.

**Public site:** **Laravel 13** + **Inertia 2** + **React 19** + **TypeScript**, with premium
animations (**Framer Motion** for reveals/stagger/animated menu, **GSAP ScrollTrigger** for
hero parallax). **Admin panel:** Blade. **SQLite** database, **Tailwind CSS 4**.

Hand-crafted *和モダン* (Japanese-modern editorial) design aligned to the Harisienne brand
identity — washi paper, sumi ink, champagne-gold, Mincho serif, hanko seal, vertical
*tategaki* labels.

---

## Running the site

PHP 8.4 lives at `C:\php` (already on the machine PATH).

```powershell
# easiest:
powershell -ExecutionPolicy Bypass -File start-dev.ps1
```

Then open:

| | URL |
|---|---|
| Public site | http://127.0.0.1:8088/ja  (also `/en`, `/zh`) |
| Admin panel | http://127.0.0.1:8088/admin/login |

> To expose it on the local network instead of just this machine, run
> `php artisan serve --host=0.0.0.0 --port=8088` and open it via the server's IP.
> Port 8088 is used because 8000 is occupied by another service on this machine.

### Editing the design live
```powershell
npm run dev      # Vite dev server with hot reload (run alongside `php artisan serve`)
```
After changing Blade/CSS for production, run `npm run build` once.

---

## Admin login

| | |
|---|---|
| Email | `admin@akemingolf.test` |
| Password | `AkeminGolf!2026` |

**⚠ Please change this password.** Update the seeder credentials or run:
```powershell
php artisan tinker --execute="`$u=App\Models\User::first(); `$u->password=Illuminate\Support\Facades\Hash::make('NEW_PASSWORD'); `$u->save();"
```

From the admin あけみん can manage, with no coding, in all three languages:
- **ページ内容** — hero / about / beauty / future / global text & images
- **最近の活動** — activities (with photo, date, place)
- **ゴルフ友** — golf friends (country, flag, Instagram, photo)
- **ゴルフと人生** — essays
- **写真** — gallery uploads
- **募集の応募** — inbox of people who applied to join

---

## Structure

```
app/
  Concerns/HasTranslations.php   # dependency-free per-locale JSON fields
  Http/Controllers/              # public + Admin/* controllers
  Http/Middleware/SetLocale.php  # {locale} URL prefix handling
  Models/                        # Section, Activity, Friend, Post, Photo, Application
config/site.php                  # brand info + supported locales
lang/{ja,en,zh}/site.php         # UI strings + fixed brand copy
resources/css/app.css            # the 和モダン design system (shared)
resources/js/                    # PUBLIC SITE — React + Inertia + TypeScript
  app.tsx                        #   Inertia entry (persistent SiteLayout)
  lib/shared.ts, lib/anim.tsx    #   useT/useUrl + Reveal/Stagger/useParallax
  Layouts/SiteLayout.tsx         #   header, animated fullscreen menu, footer
  Components/                    #   ui (hero/section-head/seal) + cards
  Pages/*.tsx                    #   the 9 public pages
resources/views/
  app.blade.php                  # Inertia root (mounts React)
  layouts/admin.blade.php        # ADMIN shell (Blade)
  admin/                         # admin dashboard + CRUD (Blade)
app/Http/Middleware/HandleInertiaRequests.php  # shared props (locale, lang, site, flash)
database/seeders/DatabaseSeeder.php   # real content + media import
_source-media/                   # original photos & video (imported into storage on seed)
```

> The old public Blade views (`resources/views/layouts/app.blade.php`, `pages/`, `components/`)
> and `resources/js/app.js` are superseded by the React frontend and can be deleted.

Reset & reseed the database (re-imports media):
```powershell
php artisan migrate:fresh --seed
```

---

## Notes
- Images/video are served from `storage/app/public` via the `public/storage` symlink
  (`php artisan storage:link`, already done).
- Translatable content is stored as locale-keyed JSON; `->t('field')` resolves the
  active locale with graceful fallback to Japanese.
- No external Composer packages were added beyond the Laravel skeleton, so the project
  stays easy to update.
