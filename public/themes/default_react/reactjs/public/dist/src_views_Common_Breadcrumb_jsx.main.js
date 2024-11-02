"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkreactjs"] = self["webpackChunkreactjs"] || []).push([["src_views_Common_Breadcrumb_jsx"],{

/***/ "./src/views/Common/Breadcrumb.jsx":
/*!*****************************************!*\
  !*** ./src/views/Common/Breadcrumb.jsx ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var react_bootstrap_Breadcrumb__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react-bootstrap/Breadcrumb */ \"./node_modules/react-bootstrap/esm/Breadcrumb.js\");\n\nfunction CommonBreadcrumb(props) {\n  if (props.breadcrumbs.length <= 0 || props.breadcrumbs === undefined) {\n    return /*#__PURE__*/React.createElement(React.Fragment, null);\n  }\n  const breadcrumbItem = props.breadcrumbs.map((value, index, array) => {\n    if (array.length - 1 === index) {\n      return /*#__PURE__*/React.createElement(react_bootstrap_Breadcrumb__WEBPACK_IMPORTED_MODULE_0__[\"default\"].Item, {\n        key: \"breadcrumb\" + value.title,\n        active: true\n      }, value.title);\n    } else {\n      return /*#__PURE__*/React.createElement(react_bootstrap_Breadcrumb__WEBPACK_IMPORTED_MODULE_0__[\"default\"].Item, {\n        key: \"breadcrumb\" + value.title,\n        href: value.href\n      }, value.title);\n    }\n  });\n  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(\"div\", {\n    className: \"container-fluid breadcumb-content mb-4\"\n  }, /*#__PURE__*/React.createElement(\"div\", {\n    className: \"container-xxl\"\n  }, /*#__PURE__*/React.createElement(react_bootstrap_Breadcrumb__WEBPACK_IMPORTED_MODULE_0__[\"default\"], null, breadcrumbItem))));\n}\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CommonBreadcrumb);\n\n//# sourceURL=webpack://reactjs/./src/views/Common/Breadcrumb.jsx?");

/***/ }),

/***/ "./node_modules/react-bootstrap/esm/Breadcrumb.js":
/*!********************************************************!*\
  !*** ./node_modules/react-bootstrap/esm/Breadcrumb.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! classnames */ \"./node_modules/classnames/index.js\");\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _ThemeProvider__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ThemeProvider */ \"./node_modules/react-bootstrap/esm/ThemeProvider.js\");\n/* harmony import */ var _BreadcrumbItem__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./BreadcrumbItem */ \"./node_modules/react-bootstrap/esm/BreadcrumbItem.js\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ \"./node_modules/react/jsx-runtime.js\");\n\"use client\";\n\n\n\n\n\n\nconst Breadcrumb = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1__.forwardRef(({\n  bsPrefix,\n  className,\n  listProps = {},\n  children,\n  label = 'breadcrumb',\n  // Need to define the default \"as\" during prop destructuring to be compatible with styled-components github.com/react-bootstrap/react-bootstrap/issues/3595\n  as: Component = 'nav',\n  ...props\n}, ref) => {\n  const prefix = (0,_ThemeProvider__WEBPACK_IMPORTED_MODULE_3__.useBootstrapPrefix)(bsPrefix, 'breadcrumb');\n  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Component, {\n    \"aria-label\": label,\n    className: className,\n    ref: ref,\n    ...props,\n    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(\"ol\", {\n      ...listProps,\n      className: classnames__WEBPACK_IMPORTED_MODULE_0___default()(prefix, listProps == null ? void 0 : listProps.className),\n      children: children\n    })\n  });\n});\nBreadcrumb.displayName = 'Breadcrumb';\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Object.assign(Breadcrumb, {\n  Item: _BreadcrumbItem__WEBPACK_IMPORTED_MODULE_4__[\"default\"]\n}));\n\n//# sourceURL=webpack://reactjs/./node_modules/react-bootstrap/esm/Breadcrumb.js?");

/***/ }),

/***/ "./node_modules/react-bootstrap/esm/BreadcrumbItem.js":
/*!************************************************************!*\
  !*** ./node_modules/react-bootstrap/esm/BreadcrumbItem.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! classnames */ \"./node_modules/classnames/index.js\");\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _restart_ui_Anchor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @restart/ui/Anchor */ \"./node_modules/@restart/ui/esm/Anchor.js\");\n/* harmony import */ var _ThemeProvider__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ThemeProvider */ \"./node_modules/react-bootstrap/esm/ThemeProvider.js\");\n/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ \"./node_modules/react/jsx-runtime.js\");\n\"use client\";\n\n\n\n\n\n\nconst BreadcrumbItem = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1__.forwardRef(({\n  bsPrefix,\n  active = false,\n  children,\n  className,\n  // Need to define the default \"as\" during prop destructuring to be compatible with styled-components github.com/react-bootstrap/react-bootstrap/issues/3595\n  as: Component = 'li',\n  linkAs: LinkComponent = _restart_ui_Anchor__WEBPACK_IMPORTED_MODULE_3__[\"default\"],\n  linkProps = {},\n  href,\n  title,\n  target,\n  ...props\n}, ref) => {\n  const prefix = (0,_ThemeProvider__WEBPACK_IMPORTED_MODULE_4__.useBootstrapPrefix)(bsPrefix, 'breadcrumb-item');\n  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Component, {\n    ref: ref,\n    ...props,\n    className: classnames__WEBPACK_IMPORTED_MODULE_0___default()(prefix, className, {\n      active\n    }),\n    \"aria-current\": active ? 'page' : undefined,\n    children: active ? children : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(LinkComponent, {\n      ...linkProps,\n      href: href,\n      title: title,\n      target: target,\n      children: children\n    })\n  });\n});\nBreadcrumbItem.displayName = 'BreadcrumbItem';\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (BreadcrumbItem);\n\n//# sourceURL=webpack://reactjs/./node_modules/react-bootstrap/esm/BreadcrumbItem.js?");

/***/ })

}]);