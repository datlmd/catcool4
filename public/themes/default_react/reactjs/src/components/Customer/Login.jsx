import { Suspense, lazy, useEffect, useState } from "react";
import { API, getRequestConfiguration } from "../../utils/callApi";
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import Row from 'react-bootstrap/Row';
import Button from 'react-bootstrap/Button';
import Message from "../UI/Message.jsx";

import { Redirect } from 'react-router-dom';

const CustomerLoginForm = (props) => {
  const initialValues = {
    identity: '',
    password: '',
    remember: false,
  };

  const [formValue, setFormValue] = useState({
    ...initialValues,
    [props.tokenName]: props.tokenValue
  });

  const [isShowError, setIsShowError] = useState(false);
  const [errors, setErrors] = useState({...initialValues});
  const [alert, setAlert] = useState("");

  const handleChange = (e) => {
    if (e.target.name == "remember") {
      setFormValue({ ...formValue, [e.target.name]: e.target.checked });
    } else {
      setFormValue({ ...formValue, [e.target.name]: e.target.value });
    } 
  };

  const login = async (e) => {
    setIsShowError(false);

    try {
      e.preventDefault();

      const response = await API.post("account/api/login", formValue, getRequestConfiguration());
      
      if (response.data.error && response.data.error !== undefined) {
        setErrors(response.data.error);
        setIsShowError(true);
      }

      if (response.data.alert && response.data.alert !== undefined) {
        setAlert(response.data.alert)
      }
      console.log(response.data);
      console.log(formValue);
     // return false;
    } catch (error) {
      console.log(error.toString());
    }
  };

  return (
    <div className="mx-auto" style={{ maxWidth: '500px' }}>

      <form onSubmit={login}>

        <Message message={errors} isShow={isShowError} type="danger" />

        <Form.Floating className="mb-3">
          <Form.Control
            name="identity"
            id="input_identity"
            type="text"
            placeholder=""
            value={formValue.identity}
            onChange={handleChange}
            isInvalid={!!errors.identity}
          />
          <label htmlFor="input_identity">{props.text_login_identity}</label>
          <Form.Control.Feedback type="invalid">
            {errors.identity}
          </Form.Control.Feedback>
        </Form.Floating>
        
        <Form.Floating className="mb-3">
          <Form.Control
            name="password"
            id="input_password"
            type="password"
            placeholder=""
            value={formValue.password}
            onChange={handleChange}
            isInvalid={!!errors.password}
          />
          <label htmlFor="input_password">{props.text_password}</label>
          <Form.Control.Feedback type="invalid">
            {errors.password}
          </Form.Control.Feedback>
        </Form.Floating>

        <Form.Group as={Row} className="mb-3" controlId="input_remember">
          <Col sm={{ span: 12 }}>
            <Form.Check
              name="remember"
              id="input_remember"
              label={props.text_remember}
              value="1"
              onChange={handleChange}
            />
          </Col>
        </Form.Group>

        <Form.Group as={Row} className="mb-3">
          <Col sm={{ span: 12}}>
            <Button type="submit">Sign in</Button>
          </Col>
        </Form.Group>
      </form>
    </div>
  );
};

export default CustomerLoginForm;
