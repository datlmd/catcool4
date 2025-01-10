import { PropsWithChildren, useEffect } from 'react'

export default function Default({ children }: PropsWithChildren) {
    //const layouts = usePage().props.layouts

    useEffect(() => {}, [])

    return <>{children}</>
}
