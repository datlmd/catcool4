'use strict'

import { useEffect } from 'react'
import ContactForm from '../../components/Contact/Form'
import LoadingContent from '../../components/Loading/Content'

import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { loadContact, contactData, contactStatus } from '../../store/modules/contact/contactSlice'

const ContactView = ({ callbackLayout }: { callbackLayout: any }) => {
  const dispatch = useAppDispatch()
  const status = useAppSelector(contactStatus)
  const data = useAppSelector(contactData)

  useEffect(() => {
    if (status === 'idle') {
      dispatch(loadContact())
    }

    if (data.layouts && data.layouts != undefined) {
      callbackLayout(data.layouts)
    }
  }, [dispatch, status, data, callbackLayout])

  if (data.status === 'pending') {
    return <LoadingContent />
  } else {
    return (
      <>
        <h1>{data.contact1}</h1>
        <ContactForm {...data} />
      </>
    )
  }
}

export default ContactView
