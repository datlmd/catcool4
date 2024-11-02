import React, { useState, useEffect, cache } from "react";
import { API, getRequestConfiguration } from "../../utils/callApi";

const PageAbout = (props) => {
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
      const response = await API.get("frontend/api/about", getRequestConfiguration());
     
      setContents(response.data);
      setIsLoading(false);
      
      sendLayout(response.data.layouts);
    } catch (error) {
      console.error(error);
    }
  };

  return <h1>About US</h1>;
};

export default PageAbout;