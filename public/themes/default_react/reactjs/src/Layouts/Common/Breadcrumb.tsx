import Breadcrumb from 'react-bootstrap/Breadcrumb'
import { ILayout, IBreadcrumbInfo } from '../../types/index'

function CommonBreadcrumb({ data }: ILayout) {
    if (data.breadcrumbs === undefined || !data.breadcrumbs) {
        return <></>
    }

    const breadcrumbItem = data.breadcrumbs.map((value: IBreadcrumbInfo, index: number) => {
        if (data.breadcrumbs.length - 1 === index) {
            return (
                <Breadcrumb.Item key={'breadcrumb' + value.title} active>
                    {value.title}
                </Breadcrumb.Item>
            )
        } else {
            return (
                <Breadcrumb.Item key={'breadcrumb' + value.title} href={value.href}>
                    {value.title}
                </Breadcrumb.Item>
            )
        }
    })
    return (
        <>
            <div className='container-fluid breadcumb-content mb-4'>
                <div className='container-xxl'>
                    <Breadcrumb>{breadcrumbItem}</Breadcrumb>
                    {/* {data.breadcrumb_title} */}
                </div>
            </div>
        </>
    )
}

export default CommonBreadcrumb
