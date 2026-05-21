# JavaScript loader app for Nextcloud

JSLoader gives administrators a simple way to inject custom JavaScript into every Nextcloud page from one central place.
It is useful for site-wide analytics, lightweight integrations, custom tracking snippets, or small UI enhancements that should apply across the whole instance.

Instead of modifying core files or managing separate app-specific scripts,
you can maintain your JavaScript through the admin settings and keep the setup easy to review and update.
The script is loaded automatically on page startup, so your code can hook into the browser after the page is ready.

## How it works
Your custom JS code will be loaded as:

```js
window.addEventListener('DOMContentLoaded', () => { /* YOUR_JS_CODE_HERE */ });
```

Make sure the code you enter is valid JavaScript and behaves well on all pages where it will run.

![](https://github.com/nextcloud/jsloader/raw/refs/heads/master/screenshots/admin-settings.png)

## Contribute

All contributions are considered to be licensed under the "AGPLv3 or any later version".
