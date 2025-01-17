import Copyright from './Footer/Copyright'
import NewsLetter from './Footer/NewsLetter'
import Social from './Footer/Social'
import MenuFooter from './Menu/Footer'
import { ILayout } from '../../types/index'

const Footer = ({ data }: ILayout) => {
    return (
        <>
            <footer id='footer'>
                <div className='footer-newsletter container-fluid'>
                    <div className='container-xxl'>
                        <div className='row'>
                            <div className='col-md-6 col-lg-8 mb-3'>
                                <NewsLetter data={data} />
                            </div>

                            <div className='col-md-6 col-lg-4 text-center'>
                                <Social data={data} />
                            </div>
                        </div>
                    </div>
                </div>
                <div className='container-fluid'>
                    <div className='container-xxl menu-footer'>
                        <MenuFooter data={data} />
                    </div>
                </div>
                <Copyright data={data} />
            </footer>
        </>
    )
}

export default Footer
