'use strict'

import { useEffect, useState, useContext, FormEventHandler } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { Head, useForm, usePage} from '@inertiajs/inertia-react';

// import Checkbox from '@/Components/Checkbox';
import InputError from '../../Components/InputError';
import InputLabel from '../../Components/InputLabel';
import CsrfInput from '../../Components/CsrfInput';
// import TextInput from '@/Components/TextInput';

const Login = ({
    status
}: {
    status?: string
}) => {

    useEffect(() => {

    }, [])

    const lang = usePage().props.lang
    const crsf_token = usePage().props.crsf_token

    const { data, setData, post, processing, errors, reset } = useForm({
        identity: '',
        password: '',
        remember: false,
        [crsf_token.name]: crsf_token.value
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
    
        post(lang.login, {
            errorBag: 'createPost',
            wantsJson: true,
            onSuccess: (response) => {
                console.log(55)
                console.log(response)
            },
           // onFinish: () => reset('password'),
        })
    }

    return (
        <DefaultLayout>
            <h1 className='text-uppercase mb-4 text-center'>{lang.text_login}</h1>
            <div className='mx-auto' style={{ maxWidth: '500px' }}>
                <form onSubmit={submit}>
                    {/* <Message message={errors} isShow={isShowError} type='danger' /> */}
                    <CsrfInput></CsrfInput>
                    <Form.Floating className='mb-3'>
                        <Form.Control
                        name='identity'
                        id='input_identity'
                        type='text'
                        placeholder=''
                        value={data.identity}
                        onChange={(e) => setData('identity', e.target.value)}
                        isInvalid={!!errors.identity}
                        />
                        {/* // <label htmlFor='input_identity'>{lang.text_login_identity}</label>
                        // <Form.Control.Feedback type='invalid'>{errors.identity}</Form.Control.Feedback> */}
                        <InputLabel htmlFor="identity" value={lang.text_login_identity} />
                        <InputError message={errors.identity} className="mt-2" />
                    </Form.Floating>

                    <Form.Floating className='mb-3'>
                        <Form.Control
                        name='password'
                        id='input_password'
                        type='password'
                        placeholder=''
                        value={data.password}
                        onChange={(e) => setData('password', e.target.value)}
                        isInvalid={!!errors.password}
                        />
                        <label htmlFor='input_password'>{lang.text_password}</label>
                        <Form.Control.Feedback type='invalid'>{errors.password}</Form.Control.Feedback>
                    </Form.Floating>

                    <Form.Group as={Row} className='mb-3' controlId='input_remember'>
                        <Col sm={{ span: 12 }}>
                        <Form.Check
                            name='remember'
                            id='input_remember'
                            label={lang.text_remember}
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.value)}
                        />
                        </Col>
                    </Form.Group>

                    <Form.Group as={Row} className='mb-3'>
                        <Col sm={{ span: 12 }}>
                            <Button type='submit'  disabled={processing}>Sign in</Button>
                        </Col>
                    </Form.Group>
                </form>
            </div>

            {status && (<div className="mb-4 text-sm font-medium text-green-600">{status}</div>)}

            {/* <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4 block">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                        />
                        <span className="ms-2 text-sm text-gray-600">
                            Remember me
                        </span>
                    </label>
                </div>

                <div className="mt-4 flex items-center justify-end">
                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Forgot your password?
                        </Link>
                    )}

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Log in
                    </PrimaryButton>
                </div>
            </form> */}
        </DefaultLayout>
    )
//}
}

export default Login
