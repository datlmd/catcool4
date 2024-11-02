export function decodeHtml(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

export function sanitizeJSONString(input) {
  return input.replace(/[\n\r\t]/g, '');;
}
