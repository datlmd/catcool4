"use strict";

import React, { useState, useEffect, cache } from "react";
import { API, getRequestConfiguration } from "../../utils/callApi";

import ContactForm from "../../components/Contact/Form.jsx";
import LoadingContent from "../../components/Loading/Content.jsx";

const PageContact = (props) => {
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
      const response = await API.get("frontend/api/contact", getRequestConfiguration());
     
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
      <h1>{contents.lang.contact}</h1>
      <ContactForm contents />
    </>
  );
};

export default PageContact;
