import { PropsWithChildren, lazy, useEffect, useState, ReactNode } from 'react'
import { Container, Row, Col } from 'react-bootstrap'
import { usePage } from '@inertiajs/inertia-react'

const importView = (subreddit: string) => lazy(() => import(`./${subreddit}`).catch(() => import(`./Common/NullView`)))

export default function DefaultBK({ children }: PropsWithChildren) {
    const layouts = usePage().props.layouts

    const [headerTopView, setHeaderTopView] = useState<ReactNode>()
    const [headerBottomView, setHeaderBottomView] = useState<ReactNode>()
    const [columnLeftView, setColumnLeftView] = useState<ReactNode>()
    const [columnRightView, setColumnRightView] = useState<ReactNode>()
    const [contentTopView, setContentTopView] = useState<ReactNode>()
    const [contentBottomView, setContentBottomView] = useState<ReactNode>()
    const [footerTopView, setFooterTopView] = useState<ReactNode>()
    const [footerBottomView, setFooterBottomView] = useState<ReactNode>()

    useEffect(() => {
        async function LoadViews(component: object, position: string) {
            if (Array.isArray(component) && component !== undefined) {
                const componentPromises = component.map(async (data) => {
                    const View = await importView(data.subreddit)
                    return <View key={data.key} data={data.data} />
                })

                switch (position) {
                    case 'header_top':
                        Promise.all(componentPromises).then(setHeaderTopView)
                        break
                    case 'header_bottom':
                        Promise.all(componentPromises).then(setHeaderBottomView)
                        break
                    case 'column_left':
                        Promise.all(componentPromises).then(setColumnLeftView)
                        break
                    case 'column_right':
                        Promise.all(componentPromises).then(setColumnRightView)
                        break
                    case 'content_top':
                        Promise.all(componentPromises).then(setContentTopView)
                        break
                    case 'content_bottom':
                        Promise.all(componentPromises).then(setContentBottomView)
                        break
                    case 'footer_top':
                        Promise.all(componentPromises).then(setFooterTopView)
                        break
                    case 'footer_bottom':
                        Promise.all(componentPromises).then(setFooterBottomView)
                        break
                }
            }
            // else {
            //   console.log(position + ' is empty')
            // }
        }

        LoadViews(layouts.header_top, 'header_top')
        LoadViews(layouts.header_bottom, 'header_bottom')
        LoadViews(layouts.column_left, 'column_left')
        LoadViews(layouts.column_right, 'column_right')
        LoadViews(layouts.content_top, 'content_top')
        LoadViews(layouts.content_bottom, 'content_bottom')
        LoadViews(layouts.footer_top, 'footer_top')
        LoadViews(layouts.footer_bottom, 'footer_bottom')
    }, [layouts])

    return (
        <>
            <div className='body'>
                {headerTopView && headerTopView.length > 0 && headerTopView}

                {headerBottomView && headerBottomView.length > 0 && headerBottomView}

                <div role='main' className='main'>
                    <Container fluid='xxl'>
                        <Row>
                            {columnLeftView && columnLeftView.length > 0 && (
                                <Col as='aside' id='column_left' className='d-none d-md-block col-3'>
                                    {columnLeftView}
                                </Col>
                            )}

                            <Col id='content'>
                                {contentTopView && contentTopView.length > 0 && contentTopView}

                                {children}

                                {contentBottomView && contentBottomView.length > 0 && contentBottomView}
                            </Col>

                            {columnRightView && columnRightView.length > 0 && (
                                <Col as='aside' id='column_right' className='d-none d-md-block col-3'>
                                    {columnRightView}
                                </Col>
                            )}
                        </Row>
                    </Container>
                </div>

                {footerTopView && footerTopView.length > 0 && footerTopView}

                {footerBottomView && footerBottomView.length > 0 && footerBottomView}
            </div>
        </>
    )
}
