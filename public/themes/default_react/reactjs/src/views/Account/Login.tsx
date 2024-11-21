'use strict'

import { useEffect, useState, useContext } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import Message from '../../components/UI/Message'
import LoadingContent from '../../components/Loading/Content'
import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { loadLogin, pageData, pageStatus, submitLogin } from '../../store/modules/account/loginSlice'

import { PageContext } from '../../contexts/Page'


interface ILogin {
  identity: string,
  password: string,
  remember: boolean,
}

const initialValues: ILogin = {
  identity: '',
  password: '',
  remember: false
}

const LoginView = ({ callbackLayout }: { callbackLayout: any }) => {
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
  const [alert, setAlert] = useState('')

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, checked } = e.target
    setFormValue((prevState) => ({
      ...prevState,
      [name]: name === 'remember' ? checked : value
    }))
  }

  const submit = (e: React.SyntheticEvent) => {
    e.preventDefault()

    setIsShowError(false)

    const params = {...formValue, [pageContext.token.name]: pageContext.token.value}
    console.log(params)
    dispatch(submitLogin(params))
      .unwrap()
      .then((response) => {
        if (response.error && response.error !== undefined) {
          setErrors(response.error)
          setIsShowError(true)
        }
        if (response.alert && response.alert !== undefined) {
          setAlert(response.alert)
        }
        // resetForm()
        // dispatch(getEmployees())
      })
      .catch((error: object) => {
        console.log(error.toString())
      })
  }

  if (data.status === 'pending') {
    return <LoadingContent />
  } else {
    return (
      <>
        <h1 className='text-uppercase mb-4 text-center'>{data.text_login}</h1>
        <div className='mx-auto' style={{ maxWidth: '500px' }}>
          <form onSubmit={submit}>
            <Message message={errors} isShow={isShowError} type='danger' />
           
            <Form.Floating className='mb-3'>
              <Form.Control
                name='identity'
                id='input_identity'
                type='text'
                placeholder=''
                value={formValue.identity}
                onChange={handleChange}
                isInvalid={!!errors.identity}
              />
              <label htmlFor='input_identity'>{data.text_login_identity}</label>
              <Form.Control.Feedback type='invalid'>{errors.identity}</Form.Control.Feedback>
            </Form.Floating>

            <Form.Floating className='mb-3'>
              <Form.Control
                name='password'
                id='input_password'
                type='password'
                placeholder=''
                value={formValue.password}
                onChange={handleChange}
                isInvalid={!!errors.password}
              />
              <label htmlFor='input_password'>{data.text_password}</label>
              <Form.Control.Feedback type='invalid'>{errors.password}</Form.Control.Feedback>
            </Form.Floating>

            <Form.Group as={Row} className='mb-3' controlId='input_remember'>
              <Col sm={{ span: 12 }}>
                <Form.Check
                  name='remember'
                  id='input_remember'
                  label={data.text_remember}
                  value='1'
                  onChange={handleChange}
                />
              </Col>
            </Form.Group>

            <Form.Group as={Row} className='mb-3'>
              <Col sm={{ span: 12 }}>
                <Button type='submit'>Sign in</Button>
              </Col>
            </Form.Group>
          </form>
        </div>
      </>
    )
  }
}

export default LoginView
