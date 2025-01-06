import { ILayout } from '../../../types/index'

const Copyright = ({ data }: ILayout) => {
    return (
        <>
            <div className='footer-copyright container-fluid'>
                <div className='container-xxl'>
                    {data.store_open && (
                        <>
                            <span className='text-opentime_title'>{data.text_business_hours}</span>
                            <span className='text-opentime_value'>{data.store_open}</span>
                            <br />
                        </>
                    )}

                    <img src={data.payment_icon} alt='Payment icons' className='img-fluid mb-2' />
                    <br />
                    <span
                        className='text-copyright'
                        data-type='lang'
                        data-key='Frontend.text_copyright'
                        dangerouslySetInnerHTML={{ __html: data.text_copyright }}
                    ></span>
                </div>
            </div>
        </>
    )
}

export default Copyright
