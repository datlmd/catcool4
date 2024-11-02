"use strict";
/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunkreactjs"] = self["webpackChunkreactjs"] || []).push([["src_views_Frontend_About_jsx"],{

/***/ "./src/utils/callApi.js":
/*!******************************!*\
  !*** ./src/utils/callApi.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   API: () => (/* binding */ API),\n/* harmony export */   getRequestConfiguration: () => (/* binding */ getRequestConfiguration),\n/* harmony export */   makeRequest: () => (/* binding */ makeRequest)\n/* harmony export */ });\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ \"./node_modules/axios/lib/axios.js\");\n\nconst API = axios__WEBPACK_IMPORTED_MODULE_0__[\"default\"].create({\n  baseURL: window.base_url,\n  responseType: 'json',\n  contentType: 'application/json',\n  headers: {\n    \"X-Requested-With\": \"XMLHttpRequest\"\n  }\n});\nconst getRequestConfiguration = authorization => {\n  const headers = {\n    'Content-Type': 'application/json'\n  };\n  if (authorization) headers.Authorization = `Bearer ${authorization}`;\n  return {\n    headers\n  };\n};\nconst makeRequest = ({\n  url,\n  values,\n  successCallback,\n  failureCallback,\n  requestType = 'POST',\n  authorization = null\n}) => {\n  const requestConfiguration = getRequestConfiguration(authorization);\n  let promise;\n  switch (requestType) {\n    case 'GET':\n      promise = API.get(url, requestConfiguration);\n      break;\n    case 'POST':\n      promise = API.post(url, values, requestConfiguration);\n      break;\n    case 'DELETE':\n      promise = API.delete(url, requestConfiguration);\n      break;\n    default:\n      return;\n  }\n  promise.then(response => {\n    const {\n      data\n    } = response;\n    successCallback(data);\n  }).catch(error => {\n    if (error.response) {\n      failureCallback(error.response.data);\n    }\n  });\n};\n\n//# sourceURL=webpack://reactjs/./src/utils/callApi.js?");

/***/ }),

/***/ "./src/views/Frontend/About.jsx":
/*!**************************************!*\
  !*** ./src/views/Frontend/About.jsx ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _utils_callApi__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../utils/callApi */ \"./src/utils/callApi.js\");\n\n\nconst PageAbout = props => {\n  const [isLoading, setIsLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(true);\n  const [contents, setContents] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)([]);\n  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {\n    //const [data, triggerData] = useCache(\"key_page_contact\", LoadPage());\n    LoadPage();\n  }, []);\n  const sendLayout = layouts => {\n    props.parentLayout(layouts);\n  };\n  const LoadPage = async () => {\n    try {\n      const response = await _utils_callApi__WEBPACK_IMPORTED_MODULE_1__.API.get(\"frontend/api/about\", (0,_utils_callApi__WEBPACK_IMPORTED_MODULE_1__.getRequestConfiguration)());\n      setContents(response.data);\n      setIsLoading(false);\n      sendLayout(response.data.layouts);\n    } catch (error) {\n      console.error(error);\n    }\n  };\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(\"h1\", null, \"About US\");\n};\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PageAbout);\n\n//# sourceURL=webpack://reactjs/./src/views/Frontend/About.jsx?");

/***/ })

}]);