import { PropsWithChildren, ReactNode, useEffect } from 'react'
import { Container, Row, Col } from 'react-bootstrap'
import { usePage } from '@inertiajs/inertia-react'

export default function Default({ children }: PropsWithChildren) {
    const layouts = usePage().props.layouts

    useEffect(() => {}, [])

    return (
        <>
            <div className='body'>
                {layouts.header_top && <span dangerouslySetInnerHTML={{ __html: layouts.header_top }}></span>}

                {layouts.header_bottom && <span dangerouslySetInnerHTML={{ __html: layouts.header_bottom }}></span>}

                <div role='main' className='main'>
                    <Container fluid='xxl'>
                        <Row>
                            {layouts.column_left && (
                                <span dangerouslySetInnerHTML={{ __html: layouts.column_left }}></span>
                            )}

                            <Col id='content'>
                                {layouts.content_top && (
                                    <span dangerouslySetInnerHTML={{ __html: layouts.content_top }}></span>
                                )}

                                {children}

                                {layouts.content_bottom && (
                                    <span dangerouslySetInnerHTML={{ __html: layouts.content_bottom }}></span>
                                )}
                            </Col>

                            {layouts.column_right && (
                                <span dangerouslySetInnerHTML={{ __html: layouts.column_right }}></span>
                            )}
                        </Row>
                    </Container>
                </div>

                {layouts.footer_top && <span dangerouslySetInnerHTML={{ __html: layouts.footer_top }}></span>}

                {layouts.footer_bottom && <span dangerouslySetInnerHTML={{ __html: layouts.footer_bottom }}></span>}
            </div>
        </>
    )
}
