'use strict'

import { useEffect, useState, useContext } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import Message from '../../components/UI/Message'
import LoadingContent from '../../components/Loading/Content'
import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { loadLogin, pageData, pageStatus, submitLogin } from '../../store/modules/account/loginSlice'

import { PageContext } from '../../contexts/Page'

interface ILogin {
  identity: string
  password: string
  remember: boolean
}

const initialValues: ILogin = {
  identity: '',
  password: '',
  remember: false
}

const LoginView = ({ callbackLayout }: { callbackLayout: void }) => {
  const pageContext = useContext(PageContext)
  const dispatch = useAppDispatch()
  const status = useAppSelector(pageStatus)
  const data = useAppSelector(pageData)

  useEffect(() => {
    if (status === 'idle') {
      dispatch(loadLogin())
    }

    if (data.layouts && data.layouts != undefined) {
      callbackLayout(data.layouts)
    }
  }, [dispatch, status, data, callbackLayout])

  const [formValue, setFormValue] = useState(initialValues)
  const [isShowError, setIsShowError] = useState<boolean>(false)
  const [errors, setErrors] = useState({ ...initialValues })



  if (data.status === 'pending') {
    return <LoadingContent />
  } else {
    return (
      <>
        <h1 className='text-uppercase mb-4 text-center'>{data.text_login}</h1>
        <div className='mx-auto' style={{ maxWidth: '500px' }}>
          fdfdf
        </div>
      </>
    )
  }
}

export default LoginView
