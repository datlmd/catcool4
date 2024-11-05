"use strict";

import React, { useState, useEffect, cache } from "react";
import { API, getRequestConfiguration } from "../../utils/callApi";

import ContactForm from "../../components/Contact/Form.jsx";
import LoadingContent from "../../components/Loading/Content.jsx";
import CustomerLoginForm from "../../components/Customer/Login.jsx";

const LoginView = (props) => {
  const [isLoading, setIsLoading] = useState(true);

  const [contents, setContents] = useState([]);

  useEffect(() => {
    //const [data, triggerData] = useCache("key_page_contact", LoadPage());
    LoadPage();
  
  }, []);

  const sendLayout = (layouts) => {
    props.parentLayout(layouts);
  };

  const LoadPage = async () => {
    try {
      const response = await API.get("account/api/login", getRequestConfiguration());
     
      setContents(response.data);
      setIsLoading(false);
      
      sendLayout(response.data.layouts);
    } catch (error) {
      console.error(error);
    }
  };

  return isLoading ? (
    <LoadingContent />
  ) : (
    <>
      <h1 className="text-uppercase mb-4 text-center">
        {contents.text_login}
      </h1>
      <CustomerLoginForm {...props} {...contents} />
    </>
  );
};

export default LoginView;
