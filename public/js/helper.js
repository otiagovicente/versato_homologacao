/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

"use strict";
eval("'use strict';\n\n/**\n * Resize function without multiple trigger\n * \n * Usage:\n * $(window).smartresize(function(){  \n *     // code here\n * });\n */\n(function ($, sr) {\n    // debouncing function from John Hann\n    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/\n    var debounce = function debounce(func, threshold, execAsap) {\n        var timeout;\n\n        return function debounced() {\n            var obj = this,\n                args = arguments;\n            function delayed() {\n                if (!execAsap) func.apply(obj, args);\n                timeout = null;\n            }\n\n            if (timeout) clearTimeout(timeout);else if (execAsap) func.apply(obj, args);\n\n            timeout = setTimeout(delayed, threshold || 100);\n        };\n    };\n\n    // smartresize \n    jQuery.fn[sr] = function (fn) {\n        return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);\n    };\n})(jQuery, 'smartresize');//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2hlbHBlci5qcz85MzEyIl0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcblxuLyoqXG4gKiBSZXNpemUgZnVuY3Rpb24gd2l0aG91dCBtdWx0aXBsZSB0cmlnZ2VyXG4gKiBcbiAqIFVzYWdlOlxuICogJCh3aW5kb3cpLnNtYXJ0cmVzaXplKGZ1bmN0aW9uKCl7ICBcbiAqICAgICAvLyBjb2RlIGhlcmVcbiAqIH0pO1xuICovXG4oZnVuY3Rpb24gKCQsIHNyKSB7XG4gICAgLy8gZGVib3VuY2luZyBmdW5jdGlvbiBmcm9tIEpvaG4gSGFublxuICAgIC8vIGh0dHA6Ly91bnNjcmlwdGFibGUuY29tL2luZGV4LnBocC8yMDA5LzAzLzIwL2RlYm91bmNpbmctamF2YXNjcmlwdC1tZXRob2RzL1xuICAgIHZhciBkZWJvdW5jZSA9IGZ1bmN0aW9uIGRlYm91bmNlKGZ1bmMsIHRocmVzaG9sZCwgZXhlY0FzYXApIHtcbiAgICAgICAgdmFyIHRpbWVvdXQ7XG5cbiAgICAgICAgcmV0dXJuIGZ1bmN0aW9uIGRlYm91bmNlZCgpIHtcbiAgICAgICAgICAgIHZhciBvYmogPSB0aGlzLFxuICAgICAgICAgICAgICAgIGFyZ3MgPSBhcmd1bWVudHM7XG4gICAgICAgICAgICBmdW5jdGlvbiBkZWxheWVkKCkge1xuICAgICAgICAgICAgICAgIGlmICghZXhlY0FzYXApIGZ1bmMuYXBwbHkob2JqLCBhcmdzKTtcbiAgICAgICAgICAgICAgICB0aW1lb3V0ID0gbnVsbDtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKHRpbWVvdXQpIGNsZWFyVGltZW91dCh0aW1lb3V0KTtlbHNlIGlmIChleGVjQXNhcCkgZnVuYy5hcHBseShvYmosIGFyZ3MpO1xuXG4gICAgICAgICAgICB0aW1lb3V0ID0gc2V0VGltZW91dChkZWxheWVkLCB0aHJlc2hvbGQgfHwgMTAwKTtcbiAgICAgICAgfTtcbiAgICB9O1xuXG4gICAgLy8gc21hcnRyZXNpemUgXG4gICAgalF1ZXJ5LmZuW3NyXSA9IGZ1bmN0aW9uIChmbikge1xuICAgICAgICByZXR1cm4gZm4gPyB0aGlzLmJpbmQoJ3Jlc2l6ZScsIGRlYm91bmNlKGZuKSkgOiB0aGlzLnRyaWdnZXIoc3IpO1xuICAgIH07XG59KShqUXVlcnksICdzbWFydHJlc2l6ZScpO1xuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL2hlbHBlci5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTs7Ozs7Ozs7O0FBU0E7OztBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ }
/******/ ]);