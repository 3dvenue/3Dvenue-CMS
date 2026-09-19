# 3Dvenue-CMS

[Official Website](https://www.3dvenue.jp/)

## **A CMS for those who want to build in their own style.**
### **Freedom adapts to you, becoming a CMS that is yours alone.**
**You’ll understand what it truly means once you start using it.**

<p align="right">
<img src="img/hero.webp" alt="3Dvenue CMS Hero Image" width="400" />
</p>

## Features

- **Not for everyone. For professionals.**  
  Built for developers who want complete control.

- **Rules exist. But breaking them won't break your site.**  
  Freedom comes first.

- **No Select Boxes. Direct Input.**  
  Type CSS values directly.

- **No Database Setup.**  
  SQLite works automatically.

- **Install Anywhere.**  
  No configuration after moving your site.

- **Three Ways to Edit.**  
  Visual, HTML, or Properties.

- **Built-in MP3 & GLB Support.**  
  Upload and use them immediately.

- **No More Color Guesswork.**  
  A built-in color palette that stays in harmony.

- **No Pre-made Parts. Build Your Own.**  
  Create exactly what you need.

- **Minimal HTML Templates.**  
  Only the HTML your page actually needs.

- **Find Image Usage Instantly.**  
  Click an image to see where it's used.

- **Drag Navigation with Children.**  
  Move parent and child items together.

- **Built-in Table Editor.**  
  Create tables without writing HTML.

- **No Third-party Analytics.**  
  Simple analytics included.

- **Download in 10 Seconds.**  
  From GitHub to your editor.

- **Use What You Want. Ignore the Rest.**  
  You're in control.

- **Import HTML, Start Editing Instantly.**  
  Upload an HTML file created by browsing AI and start editing it in the CMS editor right away.

## Roadmap

### **v1.5 — Content Export**

- Export website content section by section and download it in Markdown or JSON format.
- The exported data can be used with AI to create brochures, company profiles, PDFs, and other materials.

### **v2.0 — No-Code Virtual Exhibition Booths**

- Create virtual exhibition booths without coding, using the data exported in v1.5.
- Booths will be provided as GLB files containing JSON-based data, allowing them to be passed to AI tools or customized into more sophisticated designs by game creators and 3D developers.
- Content stored in `userData` will support interactive features such as video playback and PDF downloads.

## Installation

Upload the following files and directories to any directory on your web server.

`/`  
`├─ index.php`  
`├─ .htaccess`  
`├─ favicon.ico`  
`├─ 3d_venue_data.db`  
`├─ /common`  
`├─ /cms`  
`└─ /view`  

`/cms` is the administration directory.

The default directory name is `/cms`. However, you may freely rename it to `/admin`, `/tanaka`, or any other name, and it will continue to work normally.

Next, open `login.php` inside the administration directory and configure the following settings.

`$account = "Your-Account";`  
`$password = "Your-Password";`

※ Please change these values before uploading to a public server.

**This is all you need to get started.**

_The entire system is approximately 637KB in size (zipped)._

## Screenshots

# Dashboard

![Dashboard|471](img/toppage.webp)

# No Selector Direct Input

![Analytics|477](img/input.webp)

# Table Editor

![3D Viewer|485](img/tableeditor.webp)

# MP3 Player

![Color Settings|489](img/mp3.webp)

# 3D Viewer (GLB)

![Card Editor|491](img/glbmodel.webp)

# Color Palettes

![Table Editor|499](img/imageeditor.webp)

# Access Analytics

![Audio Player|495](img/accsess.webp)

## Requirements

- PHP 8.0 or later
- SQLite3
- Apache or Nginx

## Version History

### v1.2.5
**Released: September 20, 2026**

- Fixed issues with GLB and MP3 file uploads.
- Replaced the original custom MP3 player with the browser-native `<audio>` element.
- Fixed display issues in the editor.
- Changed the SQLite database file extension from `.qox` to `.db` so it can be opened directly with DB Browser for SQLite.
- Changed the default administration directory name from `/3dvenue` to `/cms`.
- Improved drag operations when editing templates.
- Made minor text and display adjustments.

### v1.2.0

- Added the ability to import an HTML file (e.g. one created by browsing AI) directly from the CMS editor screen, allowing immediate editing without manual setup.
- Added Asset functionality for both Section Parts and full Page information, directly from the editor screen.
- Replaced image-dependent parts with pure HTML rendering, significantly reducing overall file size (423KB → 285KB zipped).

### v1.0.1

- Fixed a minor bug.

### v1.0.0

- Initial public release — July 26, 2026

### v0.9.9

- Added MP3 playback support.
- Added 3D model (GLB) viewer support.
- Improved editor functionality.

### v0.9.8

- Added PDF upload, preview, and download support.

### v0.9.7

- Added Header and Footer Editor.

### v0.9.6

- Expanded multilingual features.
- Added access analytics page.
- Improved admin UI.

### v0.9.5

- Added multilingual support.
- Improved GUI design.
- Fixed several bugs.

### v0.9.0

- Initial public release.
- Implemented lightweight CMS structure.
- Added SQLite support.
- Included SEO tools.

## License

### 3Dvenue-CMS

3Dvenue-CMS is a lightweight and high-performance CMS focused on simplicity, speed, and flexible deployment.

### License

Copyright (c) 2026 Yoshihiro Murai  
Released under the MIT License.  
https://opensource.org/licenses/MIT

## Third-Party Libraries

- jQuery (MIT License)  
  https://jquery.com/

- jQuery UI (MIT License)  
  https://jqueryui.com/

- Tabler Icons (MIT License)  
  https://tabler.io/icons

- Three.js (MIT License)  
  https://threejs.org/

- PDF.js (Apache License 2.0)  
  https://mozilla.github.io/pdf.js/