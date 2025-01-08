import { PropsWithChildren, useEffect } from 'react'
import { Container, Row, Col } from 'react-bootstrap'
import { usePage } from '@inertiajs/inertia-react'

export default function Default({ children }: PropsWithChildren) {
    const layouts = usePage().props.layouts

    useEffect(() => {}, [])

    return (
        <>
            <div className='body'>
                {layouts.header_top && layouts.header_top.length > 0 && (
                    <span dangerouslySetInnerHTML={{ __html: layouts.header_top }}></span>
                )}

                {layouts.header_bottom && layouts.header_bottom.length > 0 && (
                    <span dangerouslySetInnerHTML={{ __html: layouts.header_bottom }}></span>
                )}

                <div role='main' className='main'>
                    <Container fluid='xxl'>
                        <Row>
                            {layouts.column_left && layouts.column_left.length > 0 && (
                                <Col as='aside' id='column_left' className='d-none d-md-block col-3'>
                                    <span dangerouslySetInnerHTML={{ __html: layouts.column_left }}></span>
                                </Col>
                            )}

                            <Col id='content'>
                                {layouts.content_top && layouts.content_top.length > 0 && (
                                    <span dangerouslySetInnerHTML={{ __html: layouts.content_top }}></span>
                                )}

                                {children}

                                {layouts.content_bottom && layouts.content_bottom.length > 0 && (
                                    <span dangerouslySetInnerHTML={{ __html: layouts.content_bottom }}></span>
                                )}
                            </Col>

                            {layouts.column_right && layouts.column_right.length > 0 && (
                                <Col as='aside' id='column_right' className='d-none d-md-block col-3'>
                                    <span dangerouslySetInnerHTML={{ __html: layouts.column_right }}></span>
                                </Col>
                            )}
                        </Row>
                    </Container>
                </div>

                {layouts.footer_top && layouts.footer_top.length > 0 && (
                    <span dangerouslySetInnerHTML={{ __html: layouts.footer_top }}></span>
                )}

                {layouts.footer_bottom && layouts.footer_bottom.length > 0 && (
                    <span dangerouslySetInnerHTML={{ __html: layouts.footer_bottom }}></span>
                )}
            </div>
        </>
    )
}
