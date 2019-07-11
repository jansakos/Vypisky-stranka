/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/4.3.0/workbox-sw.js");

self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "adminset.php",
    "revision": "a31854f2998cbaf3d7e050c961c261fb"
  },
  {
    "url": "archive.php",
    "revision": "75e597aa4ab851f890adcde747564b14"
  },
  {
    "url": "assets/css/bootstrap-black.css",
    "revision": "647725da4755762ba11fbbe9b3ffb9f0"
  },
  {
    "url": "assets/css/bootstrap-dark.css",
    "revision": "b9a99a236a9113576764916bd73d9b19"
  },
  {
    "url": "assets/css/bootstrap-default.css",
    "revision": "55b30ba36203a06e419db0a7ba5e7b6d"
  },
  {
    "url": "assets/css/chat-black.css",
    "revision": "d2f40b85d0ecb33659d98960e5af5795"
  },
  {
    "url": "assets/css/chat-dark.css",
    "revision": "d2f40b85d0ecb33659d98960e5af5795"
  },
  {
    "url": "assets/css/chat-default.css",
    "revision": "0bafe2e700ab423fe86547baa95f3aeb"
  },
  {
    "url": "assets/css/err.css",
    "revision": "d2be68a2745eb6afb74417d51e4acb7a"
  },
  {
    "url": "assets/css/font-awesome.min.css",
    "revision": "fda54673c88a8840050b4361a1bb7c7c"
  },
  {
    "url": "assets/css/font-awesome.min.old.css",
    "revision": "53fe1b7ccc4ed89cfc942c504840a64c"
  },
  {
    "url": "assets/css/index.css",
    "revision": "ca6a183153123b45914027800ad50326"
  },
  {
    "url": "assets/css/main.css",
    "revision": "5b0ab805cb1c552b1434a525a6ab7d78"
  },
  {
    "url": "assets/fonts/fontawesome-webfont.eot",
    "revision": "d06e73eab020ca784f5b174e62b11804"
  },
  {
    "url": "assets/fonts/fontawesome-webfont.svg",
    "revision": "e4c40a7643fe551f1f840f59062cda0c"
  },
  {
    "url": "assets/fonts/fontawesome-webfont.ttf",
    "revision": "9048aedb839b56a3ab8515fae8b5c921"
  },
  {
    "url": "assets/fonts/fontawesome-webfont.woff",
    "revision": "fb0869e352d83a49579e9cd4d9ac1c6b"
  },
  {
    "url": "assets/fonts/FontAwesome.otf",
    "revision": "03c70c5e828508c3c414dda119e75911"
  },
  {
    "url": "assets/ico/android-chrome-144x144.png",
    "revision": "7b348ff8578202cb4f522094c995ddfb"
  },
  {
    "url": "assets/ico/android-chrome-192x192.png",
    "revision": "8cca8595ca3bcb0003db79be73ed5186"
  },
  {
    "url": "assets/ico/android-chrome-256x256.png",
    "revision": "918ff7f6a951357e9ffdc843fb804e94"
  },
  {
    "url": "assets/ico/android-chrome-36x36.png",
    "revision": "80c63dfc1dd9451d60bbc9a599a77d66"
  },
  {
    "url": "assets/ico/android-chrome-384x384.png",
    "revision": "4293c06ca6feb1b9dc7781e982d1c4bc"
  },
  {
    "url": "assets/ico/android-chrome-48x48.png",
    "revision": "13ce0d2570e81d0f6bef34c0fdab7393"
  },
  {
    "url": "assets/ico/android-chrome-512x512.png",
    "revision": "8ffc5e6a8bef3b4ff5d0af9c6675daa3"
  },
  {
    "url": "assets/ico/android-chrome-72x72.png",
    "revision": "d8fe55540b07e9add81859477ae44baa"
  },
  {
    "url": "assets/ico/android-chrome-96x96.png",
    "revision": "a74a7a707dbe8891549f02e40b1668c3"
  },
  {
    "url": "assets/ico/apple-touch-icon-114x114.png",
    "revision": "188a1f21a1356978761dedf1df9a2f23"
  },
  {
    "url": "assets/ico/apple-touch-icon-120x120.png",
    "revision": "8d24d7a10a1277c70efb35f0c44ada7b"
  },
  {
    "url": "assets/ico/apple-touch-icon-144x144.png",
    "revision": "edb1edff34ce8c68d3e30377aa9bea1e"
  },
  {
    "url": "assets/ico/apple-touch-icon-152x152.png",
    "revision": "1db1b930626e35df77024d756e87cc5e"
  },
  {
    "url": "assets/ico/apple-touch-icon-180x180.png",
    "revision": "8fd2dbdfdc7b4c4d0422340065f346cd"
  },
  {
    "url": "assets/ico/apple-touch-icon-57x57.png",
    "revision": "14a03d15269c2aea8b50f2354de55ab5"
  },
  {
    "url": "assets/ico/apple-touch-icon-60x60.png",
    "revision": "99cc4d2155308194ab78a14a3d1cd3e7"
  },
  {
    "url": "assets/ico/apple-touch-icon-72x72.png",
    "revision": "524d1ea1af77b940d8cd7e80b3c64175"
  },
  {
    "url": "assets/ico/apple-touch-icon-76x76.png",
    "revision": "08ba8a76c51fe311ac4e743a3052fe94"
  },
  {
    "url": "assets/ico/apple-touch-icon.png",
    "revision": "8fd2dbdfdc7b4c4d0422340065f346cd"
  },
  {
    "url": "assets/ico/browserconfig.xml",
    "revision": "b01e128e3263a6f3f486174cc538900a"
  },
  {
    "url": "assets/ico/favicon-16x16.png",
    "revision": "c2c0ecef8fece0e0e3b11c58c3065dfd"
  },
  {
    "url": "assets/ico/favicon-194x194.png",
    "revision": "1c355cdeed4d79003ea426b10a826557"
  },
  {
    "url": "assets/ico/favicon-32x32.png",
    "revision": "171e44a87d7b20fb6d49a7e6acb88a77"
  },
  {
    "url": "assets/ico/favicon.ico",
    "revision": "8c384deee97b5c7bc7911e12f16906fa"
  },
  {
    "url": "assets/ico/mstile-144x144.png",
    "revision": "c4de81a6ee791a74a4466aa0648a9805"
  },
  {
    "url": "assets/ico/mstile-150x150.png",
    "revision": "659fb655f420f46324cc6c6f3b1505a0"
  },
  {
    "url": "assets/ico/mstile-310x150.png",
    "revision": "3924b8dde69367685c785b2cece94ce6"
  },
  {
    "url": "assets/ico/mstile-310x310.png",
    "revision": "032901c36d06b6b5f8fa3863a8b6becc"
  },
  {
    "url": "assets/ico/mstile-70x70.png",
    "revision": "9ecaec5cd4e2571fd3b55a1090a5ec6b"
  },
  {
    "url": "assets/ico/safari-pinned-tab.svg",
    "revision": "fda5be574795937f71e8083a968f327b"
  },
  {
    "url": "assets/js/alert.js",
    "revision": "13fbc353fd9291d3f7bdb1f8c9c85a98"
  },
  {
    "url": "assets/js/bootstrap.min.js",
    "revision": "d6834e94301cc3ab9cc013574d092b61"
  },
  {
    "url": "assets/js/jquery.min.js",
    "revision": "220afd743d9e9643852e31a135a9f3ae"
  },
  {
    "url": "assets/js/main.js",
    "revision": "f8edb061905b81ee048534d426eb85d2"
  },
  {
    "url": "assets/js/notif.js",
    "revision": "d6e9e13346d1fda71646585bf7b00aa6"
  },
  {
    "url": "assets/manifest/site.webmanifest",
    "revision": "df335f07c693d80cc926737ffe7c85ea"
  },
  {
    "url": "assets/sounds/bam.mp3",
    "revision": "543c781e5afa1d85e9b1dd0360608b9b"
  },
  {
    "url": "assets/sounds/bam.ogg",
    "revision": "13fecb49c0ab32fc74307328e708af12"
  },
  {
    "url": "changelog.php",
    "revision": "d498dfe131db24f1ddb27cd8b1119b1e"
  },
  {
    "url": "chat.php",
    "revision": "28c2d0dd592b127ef4b02a7e754c8345"
  },
  {
    "url": "config.php",
    "revision": "392a4a84be653473817888d620234d4c"
  },
  {
    "url": "contribute.json",
    "revision": "0cc38c230f75d8a8decc8b943566d013"
  },
  {
    "url": "download.php",
    "revision": "1c7cc3dd3aebb08dec3397d7ef814d70"
  },
  {
    "url": "error/e400.php",
    "revision": "e8e1fb3e76565cbc0c9896fcd11cfaee"
  },
  {
    "url": "error/e401.php",
    "revision": "2a34a3d51fda04d85309592332c46856"
  },
  {
    "url": "error/e403.php",
    "revision": "8f93a61780887a944262cc905700d290"
  },
  {
    "url": "error/e404.php",
    "revision": "9b506755c0cb21ba485d2564ada8e71c"
  },
  {
    "url": "error/e409.php",
    "revision": "1eb35f30188c180eb54d74a84d744b66"
  },
  {
    "url": "error/e410.php",
    "revision": "646b767f3268f92426513a5fdc384339"
  },
  {
    "url": "error/e500.php",
    "revision": "dc111389dc190edb0a791e4c05854e86"
  },
  {
    "url": "error/e501.php",
    "revision": "acf3759f0bfc66c75ffa4ac04bc72c7a"
  },
  {
    "url": "error/e502.php",
    "revision": "2b4df6eb35690b363a348b9eeb104f45"
  },
  {
    "url": "error/e503.php",
    "revision": "38a30ce274ace24e572081fc850e3a0c"
  },
  {
    "url": "error/e504.php",
    "revision": "383b2f5fdb9c78ea19470d143ab8f1b0"
  },
  {
    "url": "file.php",
    "revision": "4b4b4e31c615abf4646731df6d6d91cf"
  },
  {
    "url": "first.php",
    "revision": "d75779fcc7b198738606cb5bcff20699"
  },
  {
    "url": "footer.php",
    "revision": "faaaee16a81e46f97773c5261f4b321e"
  },
  {
    "url": "header.php",
    "revision": "bf095a53ca89e57a9322a14bc263cccf"
  },
  {
    "url": "index.php",
    "revision": "5950f9edd1b6f9f4901c629cedb59868"
  },
  {
    "url": "login.php",
    "revision": "2e892e63519083104380af4eff8f3339"
  },
  {
    "url": "logout.php",
    "revision": "94daa1dddf65b99a836a3273b215cfeb"
  },
  {
    "url": "messages.php",
    "revision": "381dbb4303453541f1171c70cc01f359"
  },
  {
    "url": "offline.html",
    "revision": "8b55a41558912d7e6346fa6b29497010"
  },
  {
    "url": "parts/deslist.php",
    "revision": "b34b92d819317cc5c76d38c05fd0db13"
  },
  {
    "url": "parts/head.php",
    "revision": "9f009bdce700fca5e17b23e62452887a"
  },
  {
    "url": "parts/subjects.json",
    "revision": "135b2a2aaedaf52c3d1b769727de8abf"
  },
  {
    "url": "parts/upperm.php",
    "revision": "d1cd4b7c39511e4505f68a06b1e89317"
  },
  {
    "url": "parts/upsubj.php",
    "revision": "7d14a645c3914c1ae646a355ec38f851"
  },
  {
    "url": "set.php",
    "revision": "e1f01d329f369d62128aae26a8b041eb"
  },
  {
    "url": "up.php",
    "revision": "99087ba8d1251c0b04dfe28c72d2c10c"
  },
  {
    "url": "updress.php",
    "revision": "8e655d756746ef4f347ae45def511319"
  },
  {
    "url": "upload.php",
    "revision": "9b8c23472b5e002630b2231dfd5f0c7a"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
