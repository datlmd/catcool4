export const PAGE_CONTACT = 'PAGE_CONTACT';

/**
 * Layout
 */
export interface ILayout {
  data: any
};

export interface ILayoutView {
  header_top: any,
  header_bottom: any,
  column_left: any,
  column_right: any,
  content_top: any,
  content_bottom: any,
  footer_top: any,
  footer_bottom: any
};

export interface ILayoutData {
  subreddit: string,
  data: object,
  key: string
}

/**
 * Page
 */
export interface IPage {
  data: any,
  status: 'idle' | 'pending' | 'success' | 'failed'
  error: string | null
};

/**
 * Currency
 */
export interface ICurrencyInfo {
  code: string,
  symbol_left: string,
  symbol_right: string,
  name: string,
  href: string
}

export interface ICurrency {
  list: ICurrencyInfo[],
  info: ICurrencyInfo
}

/**
 * Language
 */
export interface ILanguageInfo {
  code: string,
  text_language: string,
  icon: string
  name?: string,
  href: string,
}

export interface ILanguage {
  list: ILanguageInfo[],
  info: ILanguageInfo
}

export interface IBreadcrumbInfo {
  title: string,
  href: string
}

/**
 * Menu
 */
export interface IMenuInfo {
  menu_id?: number,
  slug: string,
  name: string,
  subs: IMenuInfo[]
}

/**
 * Message
 */
export interface IMessageInfo {
  message: any,
  isShow: boolean,
  type: string
}


// ----- Context -----

export interface IPageContext {
  token: ITokenInfo | null,
  customer?: ICustomerInfo | null
}

// ----- Token Info -----
export interface ITokenInfo {
  name: string,
  value: string
}

// ----- Customer -----

export interface ICustomerInfo {
  email: string,
  phone?: number
}