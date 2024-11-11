export function decodeHtml(html: any) {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

export function sanitizeJSONString(input: string) {
  return input.replace(/[\n\r\t]/g, '');;
}
