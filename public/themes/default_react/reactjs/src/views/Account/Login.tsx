"use strict";

import { useEffect } from "react";

import LoadingContent from "../../components/Loading/Content";
import CustomerLoginForm from "../../components/Customer/Login";

import { useAppSelector, useAppDispatch } from '../../store/hooks';
import {
  loadLogin,
  pageData,
  pageStatus,
  //pageError 
} from '../../store/modules/account/loginSlice';

const LoginView = ({callbackLayout}: {callbackLayout: any}) => {
  const dispatch = useAppDispatch();
  const status = useAppSelector(pageStatus);
  const data = useAppSelector(pageData);


  useEffect(() => {
    if (status === 'idle') {
      dispatch(loadLogin());
    }

    if (data.layouts && data.layouts != undefined) {
      callbackLayout(data.layouts);
    };
    
  }, [dispatch, status, data]);

  if (data.status === "pending") {
    return <LoadingContent />
  } else { 
    return (
      <>
        <h1 className="text-uppercase mb-4 text-center">
          {data.text_login}
        </h1>
        <CustomerLoginForm {...data} />
      </>
    );
  }
};

export default LoginView;
