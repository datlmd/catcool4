export const PAGE_CONTACT = "PAGE_CONTACT";

export interface ILayout {
  data: any,
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

export interface IPage {
  data: any,
  status: 'idle' | 'pending' | 'success' | 'failed'
  error: string | null
};