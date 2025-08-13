import { PropsWithChildren, useEffect } from 'react'
import { usePage } from '@inertiajs/react'
import DOMPurify from 'dompurify'
import parse from 'html-react-parser'
import { ILayoutView } from '@/types'

export default function Default({ children, layouts }: PropsWithChildren<{ layouts: ILayoutView}>) {
    

    useEffect(() => {}, [])

    return <>
        <div className="">
           
            {layouts?.header_top && <div dangerouslySetInnerHTML={{ __html: layouts.header_top }}></div>}
            {layouts?.header_bottom && <p dangerouslySetInnerHTML={{ __html: layouts.header_bottom }}></p>}

            <div role="main" className="main">

                <div className="container-xxl">

                    <div className="row">
                        {/* <?php if (!empty($page_layouts['column_left'])) : ?>
                            <aside id="column_left" class="col-3 d-none d-md-block">
                                <?= $page_layouts['column_left'] ?>
                            </aside>
                        <?php endif; ?> */}

                        <div id="content" className="col">
                            {/* <?= $page_layouts['content_top'] ?? "" ?> */}

                            {children}

                            {/* <?= $page_layouts['content_bottom'] ?? "" ?> */}
                        </div>
                        {layouts?.column_right &&
                            (<aside id="column_right" className="col-3 d-none d-md-block">
                                <div dangerouslySetInnerHTML={{ __html: layouts.column_right }}></div>
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
            
        </div>
        
    </>
}
