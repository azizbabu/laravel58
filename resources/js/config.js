const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
const getUrl = window.location;
const siteUrlPrependInfo = getUrl .protocol + "//" + getUrl.host + "/"

export const siteUrlMain = siteUrl.replace(siteUrlPrependInfo, '')