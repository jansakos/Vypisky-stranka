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
    "revision": "429b247377866183399b1d620a9c96e6"
  },
  {
    "url": "another.php",
    "revision": "e2e31402aa0eb95dcfd0bec6484211c6"
  },
  {
    "url": "assets/css/bootstrap.css",
    "revision": "c0153f273bc0ca4848e25e34629bfc49"
  },
  {
    "url": "assets/css/chat.css",
    "revision": "ebdc44f57b9517f00dc0d9f1b14d1cae"
  },
  {
    "url": "assets/css/err.css",
    "revision": "d2be68a2745eb6afb74417d51e4acb7a"
  },
  {
    "url": "assets/css/font-awesome.min.css",
    "revision": "892f416e54029185315ff7975112c3c2"
  },
  {
    "url": "assets/css/index.css",
    "revision": "ca6a183153123b45914027800ad50326"
  },
  {
    "url": "assets/css/main.css",
    "revision": "8f06b1995ca601221df302113ec8396f"
  },
  {
    "url": "assets/fonts/fontawesome-webfont.eot",
    "revision": "d06e73eab020ca784f5b174e62b11804"
  },
  {
    "url": "assets/ico/favicon.ico",
    "revision": "8c384deee97b5c7bc7911e12f16906fa"
  },
  {
    "url": "assets/ico/safari-pinned-tab.svg",
    "revision": "fda5be574795937f71e8083a968f327b"
  },
  {
    "url": "assets/js/bootstrap.min.js",
    "revision": "d6834e94301cc3ab9cc013574d092b61"
  },
  {
    "url": "assets/js/jquery-3.3.1.min.js",
    "revision": "a09e13ee94d51c524b7e2a728c7d4039"
  },
  {
    "url": "assets/js/main.js",
    "revision": "7b5256c4cf8f1aa0002f4a0acab60feb"
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
    "url": "changelog.php",
    "revision": "31c47f5ae9c7ba9b55ee1c2bc06c9493"
  },
  {
    "url": "chat.php",
    "revision": "0a8da69db0b8c37b7d46aec6896127d9"
  },
  {
    "url": "config.php",
    "revision": "02da3e662d2eda365486cb504d685934"
  },
  {
    "url": "delete.php",
    "revision": "7afa10e3e012cc4c7260982a79630608"
  },
  {
    "url": "down.php",
    "revision": "38d41a7d24794d4f1fda8d96f4ebae63"
  },
  {
    "url": "download.php",
    "revision": "75b569d7a70e69d6ac2c6885d252d4c3"
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
    "revision": "807a34ec23bf690849d882aa40726bad"
  },
  {
    "url": "first.php",
    "revision": "9b6bd96dd6f0c230090e68936b9578e9"
  },
  {
    "url": "footer.php",
    "revision": "146ea26eb9767a24d5be37f44ad8ac02"
  },
  {
    "url": "header.php",
    "revision": "2688adb29d837349b53d4e31f5d83fac"
  },
  {
    "url": "indev.php",
    "revision": "6e7523b312bf12173c5d58bbb8c7a19a"
  },
  {
    "url": "index.php",
    "revision": "7ae3bd0063a696154150f5cecd6d67de"
  },
  {
    "url": "login.php",
    "revision": "0157b60d63cecf462d4d74dd9fe2b8f3"
  },
  {
    "url": "logout.php",
    "revision": "94daa1dddf65b99a836a3273b215cfeb"
  },
  {
    "url": "messages.php",
    "revision": "01ff98be88f1de226db0adb3c690b904"
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
    "revision": "bc7a65a4a8b2c29b875ce37de7bd38fb"
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
    "revision": "1ffdee14f8b1c8301400f86477164287"
  },
  {
    "url": "up.php",
    "revision": "32e69612086c27a64ac771fc07a032cb"
  },
  {
    "url": "updress.php",
    "revision": "f1139209e000dd59fc9787ae12a8077c"
  },
  {
    "url": "upload.php",
    "revision": "45390f160fc833a9551030ae257243c0"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
