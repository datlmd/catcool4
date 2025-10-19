import { JSXElementConstructor, PropsWithChildren, ReactElement, ReactNode, ReactPortal, useEffect } from 'react'
import { usePage, Link } from '@inertiajs/react'
import parse, { domToReact, Element, HTMLReactParserOptions }  from 'html-react-parser'
import { ILayoutView } from '@/types'
import { UrlMethodPair } from '@inertiajs/core'

export default function Default({ children, layouts }: PropsWithChildren<{ layouts: ILayoutView}>) {
    
    const options_ = {
        replace: (domNode: { name: string; attribs: { react: string | undefined; href: string | UrlMethodPair | undefined; class: string | undefined; title: string | undefined; }; children: { data: string | number | boolean | ReactElement<any, string | JSXElementConstructor<any>> | Iterable<ReactNode> | ReactPortal | null | undefined }[] }) => {
          //if (domNode.name === 'a' && domNode.attribs?.href && domNode.attribs?.react) {
        if (domNode.name === 'a' && domNode.attribs?.href) {
            const { href, class: className, title } = domNode.attribs;

            return (
              <Link href={href} className={className} title={title}>
                {domNode.children[0]?.data}
              </Link>
            );
          }
        },
      };

      const options: HTMLReactParserOptions = {
        replace: (domNode) => {
          if (domNode.name === 'a' && domNode.attribs && domNode.attribs.href) {
            const { href, class: classAttr, title, ...restAttribs } = domNode.attribs;
    
            // chuẩn hóa class => className cho React
            const props: Record<string, any> = { href, title, ...restAttribs };
            if (classAttr) {
              props.className = classAttr;
            }
    
            // Chuyển children của <a>
            const children = domToReact(domNode.children, options);
    
            return (
              <Link key={href} {...props}>
                {children}
              </Link>
            );
          }
          return undefined;
        }
      };

    useEffect(() => {}, [])

    return <>
        {/* div_body_class */}
        <div className="body">
           
            {layouts?.header_top && parse(layouts.header_top, options)}
            {layouts?.header_bottom && parse(layouts.header_bottom, options)}

            <div role="main" className="main">

                <div className="container-xxl">

                    <div className="row">
                        {layouts?.column_left &&
                            (<aside id="column_left" className="col-3 d-none d-md-block">
                                {parse(layouts.column_left, options)}
                            </aside>)
                        }

                        <div id="content" className="col">
                            {layouts?.content_top && parse(layouts.content_top, options)}
                            {/* <?= $page_layouts['content_top'] ?? "" ?> */}

                            {children}

                            {layouts?.content_bottom && parse(layouts.content_bottom, options)}
                        </div>
                        {layouts?.column_right &&
                            (<aside id="column_right" className="col-3 d-none d-md-block">
                                {parse(layouts.column_right, options)}
                            </aside>)
                        }
                        {/* <?php if (!empty($page_layouts['column_right'])): ?>
                            <aside id="column_right" class="col-3 d-none d-md-block">
                                <?= $page_layouts['column_right'] ?? "" ?>
                            </aside>
                        <?php endif; ?> */}
                    </div>

                </div>

            </div>

            {layouts?.footer_top && parse(layouts.footer_top, options)}
            {layouts?.footer_bottom && parse(layouts.footer_bottom, options)}
            
        </div>
        
    </>
}
