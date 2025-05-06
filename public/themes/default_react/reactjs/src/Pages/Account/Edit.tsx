'use strict'

import { useEffect, useState, FormEventHandler } from 'react'
import { usePage, useForm } from '@inertiajs/react'
import DatePicker from 'react-datepicker'
import { vi } from 'date-fns/locale'
import { format } from 'date-fns'
import { Form, Spinner } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { IPage } from '@/types'
import 'react-datepicker/dist/react-datepicker.css'

const Edit = ({ contents, alert }: IPage) => {
    const crsf_token = usePage().props.crsf_token ?? { name: '', value: '' }

    useEffect(() => {}, [])

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, checked } = e.target
        setData((prevState) => ({
            ...prevState,
            [name]: name === 'remember' ? checked : value
        }))
    }

    const handleSelectChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setData((prevState) => ({
            ...prevState,
            [e.target.name]: e.target.value
        }))
    }

    const { data, transform, setData, post, errors, processing, reset } = useForm({
        first_name: contents.customer_info.first_name ?? '',
        last_name: contents.customer_info.last_name ?? '',
        gender: contents.customer_info.gender ?? '',
        email: contents.customer_info.email ?? '',
        username: contents.customer_info.username ?? '',
        phone: contents.customer_info.phone ?? '',
        dob: contents.customer_info.dob ? format(contents.customer_info.dob, contents.date_format) : '',
        customer_group_id: contents.customer_info.customer_group_id ?? ''
        //[crsf_token.name]: crsf_token.value
    })

    const submit: FormEventHandler = async (e) => {
        e.preventDefault()

        transform((data) => ({
            ...data,
            dob: data.dob ? format(data.dob, contents.date_format) : '',
            [crsf_token.name]: crsf_token.value
        }))

        post(contents.save, {
            //forceFormData: true,
            //preserveScroll: true,
            // onSuccess: (response) => {
            //     //reset()
            //     console.log(response);
            // },
            onError: (errors) => {
                console.log(errors)
            }
        })
    }

    return (
        <DefaultLayout>
            <h1 className='mb-3 text-start'>{contents.text_account_edit_title}</h1>
            {alert && <div id='account_edit_alert' className='mb-4' dangerouslySetInnerHTML={{ __html: alert }}></div>}

            <form onSubmit={submit}>
                <fieldset>
                    <legend className='mb-4'>{contents.text_your_details}</legend>

                    <div className='form-group row px-4'>
                        <div className='col-md-6 mb-4'>
                            <Form.Label htmlFor='input_first_name' className='form-label fw-bold required-label'>
                                {contents.text_first_name}
                            </Form.Label>
                            <Form.Control
                                type='text'
                                name='first_name'
                                id='input_first_name'
                                value={data.first_name}
                                placeholder={contents.text_first_name}
                                aria-describedby='help_first_name'
                                onChange={handleChange}
                                isInvalid={!!errors.first_name}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.first_name}</Form.Control.Feedback>
                            <Form.Text id='help_first_name' muted>
                                {contents.help_first_name}
                            </Form.Text>
                        </div>
                        <div className='col-md-6 mb-4'>
                            <Form.Label htmlFor='input_last_name' className='form-label fw-bold required-label'>
                                {contents.text_last_name}
                            </Form.Label>
                            <Form.Control
                                type='text'
                                name='last_name'
                                id='input_last_name'
                                value={data.last_name}
                                placeholder={contents.text_last_name}
                                aria-describedby='help_last_name'
                                onChange={handleChange}
                                isInvalid={!!errors.last_name}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.last_name}</Form.Control.Feedback>
                            <Form.Text id='help_last_name' muted>
                                {contents.help_last_name}
                            </Form.Text>
                        </div>
                    </div>

                    <div className='form-group row mb-4 px-4'>
                        <label className='form-label fw-bold required-label'>{contents.text_gender}</label>
                        <div className='col-12' key='inline-radio'>
                            <Form.Check
                                inline
                                label={contents.text_male}
                                name='gender'
                                type='radio'
                                id='gender_male'
                                checked={data.gender == contents.genders.male}
                                onChange={handleChange}
                                isInvalid={!!errors.gender}
                            />
                            <Form.Check
                                inline
                                label={contents.text_female}
                                name='gender'
                                type='radio'
                                id='gender_female'
                                checked={data.gender == contents.genders.female}
                                onChange={handleChange}
                                isInvalid={!!errors.gender}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.gender}</Form.Control.Feedback>
                        </div>
                    </div>

                    <div className='form-group row mb-4 px-4'>
                        <div className='col-12'>
                            <Form.Group controlId='datetimePicker'>
                                <Form.Label className='form-label fw-bold required-label'>
                                    {contents.text_dob}
                                </Form.Label>
                                <div className='col-12'>
                                    <DatePicker
                                        name='dob'
                                        id='input_dob'
                                        selected={data.dob}
                                        onChange={(date: Date | null) => {
                                            setData({ ...data, dob: date != null ? date : '' })
                                        }}
                                        dateFormat={contents.date_format}
                                        //timeFormat="HH:mm"
                                        locale={contents.language_code == 'vi' ? vi : ''}
                                        className={`form-control ${!!errors.dob ? 'is-invalid' : ''}`}
                                    />
                                    <Form.Control.Feedback type='invalid' className='d-block'>
                                        {errors.dob}
                                    </Form.Control.Feedback>
                                </div>
                            </Form.Group>
                        </div>
                    </div>

                    <div className='form-group row mb-4 px-4'>
                        <Form.Label htmlFor='input_email' className='form-label fw-bold required-label'>
                            {contents.text_email}
                        </Form.Label>
                        <div className='col-12'>
                            <Form.Control
                                type='text'
                                name='email'
                                id='input_email'
                                value={data.email}
                                placeholder={contents.text_email}
                                onChange={handleChange}
                                isInvalid={!!errors.email}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.email}</Form.Control.Feedback>
                        </div>
                    </div>

                    <div className='form-group row mb-4 px-4'>
                        <Form.Label htmlFor='input_username' className='form-label fw-bold'>
                            {contents.text_username}
                        </Form.Label>
                        <div className='col-12'>
                            <Form.Control
                                type='text'
                                name='username'
                                id='input_username'
                                value={data.username}
                                placeholder={contents.text_username}
                                onChange={handleChange}
                                isInvalid={!!errors.username}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.username}</Form.Control.Feedback>
                        </div>
                    </div>

                    <div className='form-group row mb-4 px-4'>
                        <Form.Label htmlFor='input_phone' className='form-label fw-bold'>
                            {contents.text_phone}
                        </Form.Label>
                        <div className='col'>
                            <Form.Control
                                type='text'
                                name='phone'
                                id='input_phone'
                                value={data.phone}
                                placeholder={contents.text_phone}
                                onChange={handleChange}
                                isInvalid={!!errors.phone}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.phone}</Form.Control.Feedback>
                        </div>
                    </div>

                    {contents.customer_groups !== undefined && contents.customer_groups.length > 0 && (
                        <div className='form-group row mb-4 px-4'>
                            <Form.Label htmlFor='input_customer_group_id' className='form-label fw-bold required-label'>
                                {contents.text_customer_group}
                            </Form.Label>
                            <div className='col'>
                                <Form.Select
                                    name='customer_group_id'
                                    id='input_customer_group_id'
                                    onChange={handleSelectChange}
                                    value={data.customer_group_id}
                                >
                                    {contents.customer_groups.map(
                                        (customer_group: { customer_group_id: number; name: string }) => (
                                            <option
                                                key={customer_group.customer_group_id}
                                                value={customer_group.customer_group_id}
                                            >
                                                {customer_group.name}
                                            </option>
                                        )
                                    )}
                                </Form.Select>
                                <Form.Control.Feedback type='invalid'>{errors.customer_group_id}</Form.Control.Feedback>
                            </div>
                        </div>
                    )}
                </fieldset>

                <div className='form-group row my-4'>
                    <div className='col'>
                        <a href={contents.back} className='btn btn-light'>
                            {contents.button_back}
                        </a>
                    </div>
                    <div className='col text-end'>
                        <button type='submit' disabled={processing} className='btn btn-primary px-4'>
                            {processing && <Spinner animation='grow' className='me-1' size='sm' />}
                            {contents.button_save}
                        </button>
                    </div>
                </div>
            </form>
        </DefaultLayout>
    )
}

export default Edit
