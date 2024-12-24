import { PropsWithChildren, ReactNode, useState, useEffect } from 'react'
import { Container, Row, Col } from 'react-bootstrap'
import { Link, usePage } from '@inertiajs/inertia-react'

export default function Default({
  header_bottom,
  column_left,
  column_right,
  content_top,
  content_bottom,
  footer_top,
  footer_bottom,
  children,
}: PropsWithChildren<{ header_bottom?: ReactNode, column_left?: ReactNode, column_right?: ReactNode, content_top?: ReactNode, content_bottom?: ReactNode, footer_top?: ReactNode, footer_bottom?: ReactNode }>) {

  const layouts = usePage().props.layouts

  useEffect(() => {
    
  }, [])

  return (
    <>
      <div className='body'>
        {layouts.header_top && (
          <span dangerouslySetInnerHTML={{ __html: layouts.header_top }}></span>
        )}

        {header_bottom && header_bottom}

        <div role='main' className='main'>
          <Container fluid='xxl'>
            <Row>
              
              {column_left && column_left}

              <Col as='aside' xs={{ order: 0 }} id='content_left' className='d-none d-md-block col-3'>
                <nav>
                  <ul>
                    <li>
                      <Link href='/dev/catcool4/public/'>Home</Link>
                    </li>
                    <li>
                      <Link href='/dev/catcool4/public/about'>About</Link>
                    </li>
                    <li>
                      <Link href='/dev/catcool4/public/contact'>Contact</Link>
                    </li>
                  </ul>
                </nav>
              </Col>
              <Col id='content'>
                {content_top && content_top}

                {children}

                {content_bottom && content_bottom}
              </Col>

              {column_right && column_right}
            </Row>
          </Container>
        </div>

        {footer_top && footer_top}

        {footer_bottom && footer_bottom}
      </div>
    </>
  )
}
