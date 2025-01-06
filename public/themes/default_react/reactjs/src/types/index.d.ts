export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

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