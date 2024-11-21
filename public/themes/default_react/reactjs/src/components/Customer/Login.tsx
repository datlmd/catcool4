import { Suspense, lazy, useEffect, useState, useContext } from 'react'
import FloatingLabel from 'react-bootstrap/FloatingLabel'
import Col from 'react-bootstrap/Col'
import Form from 'react-bootstrap/Form'
import Row from 'react-bootstrap/Row'
import Button from 'react-bootstrap/Button'
import Message from '../UI/Message'
import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { submitLogin } from '../../store/modules/account/loginSlice'
//import { Redirect } from 'react-router-dom'
import { ILayout } from 'src/store/types'
import { PageContext } from '../../contexts/Page'

interface ILogin {
  identity: string,
  password: string,
  remember: boolean
}

const initialValues: ILogin = {
  identity: '',
  password: '',
  remember: false
}

const CustomerLoginForm = ({ data }: ILayout) => {
  const pageContext = useContext(PageContext)
  const dispatch = useAppDispatch()
  const [formValue, setFormValue] = useState(initialValues)

  const [isShowError, setIsShowError] = useState(false)
  const [errors, setErrors] = useState({ ...initialValues })
  const [alert, setAlert] = useState('')

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, checked } = e.target
    setFormValue((prevState) => ({
      ...prevState,
      [name]: name === "remember" ? checked : value
    }))
  }

  const submit = (e: React.SyntheticEvent) => {
    e.preventDefault()
    setIsShowError(false)
//     setFormValue({
//       ...formValue,
//       [csrf.name]: csrf.value
//     })
// console.log(formValue)
    dispatch(submitLogin(formValue))
      .unwrap()
      .then((response) => {
        if (response.error && response.error !== undefined) {
          setErrors(response.error)
          setIsShowError(true)
        }
        if (response.alert && response.alert !== undefined) {
          setAlert(response.alert)
        }
        // toast.success(response)
        // resetForm()
        // dispatch(getEmployees())
      })
      .catch((error: object) => {
        console.log(error.toString())
        //toast.error(error)
      })
  }

  return (
    <div className='mx-auto' style={{ maxWidth: '500px' }}>
      <form onSubmit={submit}>
        <Message message={errors} isShow={isShowError} type='danger' />
        <Form.Control
            name={pageContext.token.name}
            id='input_csrf'
            type='text'
            placeholder=''
            value={pageContext.token.value}
        />
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
          <Form.Control.Feedback type='invalid'>{data.identity}</Form.Control.Feedback>
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
  )
}

export default CustomerLoginForm
