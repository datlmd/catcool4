'use strict'

import { useEffect, useState, FormEventHandler } from 'react'
import { usePage } from '@inertiajs/inertia-react'
import DefaultLayout from '../../Layouts/DefaultLayout'
import Form from 'react-bootstrap/Form'
import { API, getRequestToken } from '../../utils/callApi'

const Edit = ({ contents, alert }: { contents?: any; alert?: string }) => {

    const crsf_token = usePage().props.crsf_token
    const [data, setData] = useState({
        first_name: '',
        last_name: '',
        email: '',
        username: '',
        phone: '',
        [crsf_token.name]: crsf_token.value
    })
    const [errors, setErrors] = useState({
        first_name: '',
        last_name: '',
        email: '',
        username: '',
        phone: '',
    })
    const [isShowError, setIsShowError] = useState<boolean>(false)

    useEffect(() => {}, [])

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, checked } = e.target
        setData((prevState) => ({
            ...prevState,
            [name]: name === 'remember' ? checked : value
        }))
    }

    const submit: FormEventHandler = async (e) => {
        e.preventDefault()
        try {
            const response = await API.post(contents.save, data, getRequestToken())

            if (response.data.errors && response.data.errors !== undefined) {
                setErrors(response.data.errors)
                setIsShowError(true)
            }

            if (response.data.redirect !== undefined && response.data.redirect != '') {
                window.location = response.data.redirect
            }
        } catch (error) {
            setErrors(error)
            setIsShowError(true)
            console.log(error)
        }
    }

    return (
        <DefaultLayout>
            <h1 className="mb-3 text-start">
                {contents.text_account_edit_title}
            </h1>
            <div id="account_edit_alert">{alert}</div>

            <form onSubmit={submit}>
                <fieldset>
                    <legend className="mb-4">{contents.text_your_details}</legend>

                    <div className="form-group row px-4">
                        <div className="col-md-6 mb-4">
                            <Form.Label htmlFor="input_first_name" className="form-label fw-bold required-label">{contents.text_first_name}</Form.Label>
                            <Form.Control 
                                type='text'
                                name="first_name"
                                id='input_first_name'
                                value={contents.customer_info.first_name}
                                placeholder={contents.holder_first_name}
                                aria-describedby='help_first_name'
                                onChange={handleChange}
                                isInvalid={!!errors.first_name}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.first_name}</Form.Control.Feedback>
                            <Form.Text id='help_first_name' muted>
                                {contents.help_first_name}
                            </Form.Text>
                        </div>
                        <div className="col-md-6 mb-4">
                            <Form.Label htmlFor="input_last_name" className="form-label fw-bold required-label">{contents.text_last_name}</Form.Label>
                            <Form.Control 
                                type='text'
                                name="last_name"
                                id='input_last_name'
                                value={contents.customer_info.last_name}
                                placeholder={contents.holder_last_name}
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

                    <div className="form-group row mb-4 px-4">
                        
                        <label className="form-label fw-bold required-label">{contents.text_gender}</label>
                            
                        {/* <div className="col-6">
                            <div className="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                                <label className="form-check-label w-100 ps-1" htmlFor="gender_male">{contents.text_male}</label>
                                <input className="form-check-input {if validation_show_error('gender}is-invalid{/if}" type="radio" name="gender" id="gender_male" value="{GENDER_MALE}" {if old('gender', $customer_info.gender) eq GENDER_MALE || !in_array(old('gender', $customer_info.gender), [GENDER_MALE,GENDER_FEMALE,GENDER_OTHER])}checked{/if} />
                            </div>
                        </div>
                        <div className="col-6">
                            <div className="form-check border rounded-1 w-100 p-2 overflow-hidden d-flex flex-row">
                                <label className="form-check-label w-100 ps-1" htmlFor="gender_female">{contents.text_female}</label>
                                <input className="form-check-input {if validation_show_error('gender}is-invalid{/if}" type="radio" name="gender" id="gender_female" value="{GENDER_FEMALE}" {if old('gender', $customer_info.gender) eq GENDER_FEMALE}checked{/if} />
                            </div>
                        </div> */}
                        
                    </div>

                    <div className="form-group row mb-4 px-4">
                        <div className="col-12">
                            <Form.Label htmlFor="input_dob" className="form-label fw-bold required-label">{contents.text_dob}</Form.Label>
                            <div className="input-group date show-date-picker" id="show-date-picker"
                                data-target-input="nearest" data-date-format="{get_date_format_ajax()|upper}"
                                data-date-locale="{language_code()}">
                                    <Form.Control 
                                        type='text'
                                        name="dob"
                                        id='input_dob'
                                        value={contents.customer_info.dob}
                                        placeholder=''
                                        onChange={handleChange}
                                        isInvalid={!!errors.last_name}
                                    />
                                {/* <input type="text" 
                                    name="dob" 
                                    id="input_dob" 
                                    className="form-control datetimepicker-input"
                                    {if old('dob', $customer_info.dob)}value="{old('dob', $customer_info.dob)|date_format:get_date_format(true)}"{/if} 
                                    placeholder="{get_date_format_ajax()}" 
                                    data-target="#show-date-picker" 
                                /> */}
                                <div className="input-group-text" data-target="#show-date-picker"
                                    data-toggle="datetimepicker"><i className="fa fa-calendar-alt"></i></div>
                            </div>
                            {/* <div id="error_dob" className="invalid-feedback">{validation_show_error("dob")}</div> */}
                        </div>
                    </div>

                    <div className="form-group row mb-4 px-4">
                        <Form.Label htmlFor="input_email" className="form-label fw-bold required-label">{contents.text_email}</Form.Label>
                        <div className="col-12">
                        
                            <Form.Control 
                                type='text'
                                name="email"
                                id='input_email'
                                value={contents.customer_info.email}
                                placeholder={contents.text_email}
                                onChange={handleChange}
                                isInvalid={!!errors.email}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.email}</Form.Control.Feedback>
                
                        </div>
                    </div>

                    <div className="form-group row mb-4 px-4">
                        <Form.Label htmlFor="input_username" className="form-label fw-bold required-label">{contents.text_username}</Form.Label>
                        <div className="col-12">

                            <Form.Control 
                                type='text'
                                name="username"
                                id='input_username'
                                value={contents.customer_info.username}
                                placeholder={contents.text_username}
                                onChange={handleChange}
                                isInvalid={!!errors.username}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.username}</Form.Control.Feedback>

                        </div>
                    </div>

                    <div className="form-group row mb-4 px-4">
                        <Form.Label htmlFor="input_phone" className="form-label fw-bold required-label">{contents.text_phone}</Form.Label>
                        <div className="col-12">

                            <Form.Control 
                                type='text'
                                name="phone"
                                id='input_phone'
                                value={contents.customer_info.phone}
                                placeholder={contents.text_phone}
                                onChange={handleChange}
                                isInvalid={!!errors.phone}
                            />
                            <Form.Control.Feedback type='invalid'>{errors.phone}</Form.Control.Feedback>

                            
                        </div>
                    </div>

                    {/* {if $customer_group_list|@count > 1}
                        <div className="form-group row mb-4 px-4">
                            <div className="col">
                                <label htmlFor="input_customer_group_id" className="form-label fw-bold required-label">{contents.text_customer_group}</label>
                                <select name="customer_group_id" id="input_customer_group_id" className="form-control">
                                    {foreach $customer_group_list as $customer_group}
                                        <option value="{$customer_group.customer_group_id}" {set_select('customer_group_id', $customer_group.customer_group_id, ($customer_group.customer_group_id == $customer_info.customer_group_id))}>{$customer_group.name}</option>
                                    {/foreach}
                                </select>
                                <div id="error_customer_group_id" className="invalid-feedback"></div>
                            </div>
                        </div>
                    {/if} */}
                    
                </fieldset>
                
                <div className="form-group row my-4">
                    <div className="col">
                        <a href="contents.back" className="btn btn-light">{contents.button_back}</a>
                    </div>
                    <div className="col text-end">
                        <button type="submit" className="btn btn-primary px-4">{contents.button_save}</button>
                    </div>
                </div>
            </form>
        </DefaultLayout>
    )
}

export default Edit
