/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/pharmatron.js":
/***/ (function(module, exports) {

String.prototype.reverse = function () {
  splitext = this.split("");
  revertext = splitext.reverse();
  reversed = revertext.join("");

  return reversed;
};
$.fn.barcode = function (s) {
  var result = 0;
  var rs = s.reverse();
  for (counter = 0; counter < rs.length; counter++) {
    result = result + parseInt(rs.charAt(counter)) * Math.pow(3, (counter + 1) % 2);
  }
  var digit = (10 - result % 10) % 10;
  this.val(s + '' + digit);

  return this;
};
$.fn.alpha_num = function (length) {
  var result = '';
  var chars = '01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  for (var i = length; i > 0; --i) {
    result += chars[Math.floor(Math.random() * chars.length)];
  }
  this.val(result);

  return this;
};
if ($.fn.datepicker) {
  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd',
    orientation: "top auto",
    autoclose: true,
    todayHighlight: true
  });
}
if ($.fn.select2) {
  $('.select2').select2({
    width: '100%'
  });
}
$('input[type=number]').on('focus', function (e) {
  $(this).bind("wheel mousewheel", function (e) {
    e.preventDefault();
  });
});

$.fn.notify = function () {
  var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'The operation was successful';
  var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'Success';
  var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'success';

  new PNotify({
    title: title,
    text: '<p>' + message + '</p>',
    type: type,
    styling: 'fontawesome'
  });
};

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/pharmatron.js");


/***/ })

/******/ });