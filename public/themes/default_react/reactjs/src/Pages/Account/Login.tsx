'use strict'

import { useEffect, useState, useContext } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { Head } from '@inertiajs/inertia-react';


const Login = ({ message }: { message: string }) => {


  useEffect(() => {
   
  }, [])

 

  // if (data.status === 'pending') {
  //   return <LoadingContent />
  // } else {
    return (
      <DefaultLayout
        // header_bottom={

        // }
        // column_left={}
        // column_right={}
        // content_top={}
        // content_bottom={}
        // footer_top={}
        // footer_bottom={}
      >
        <h1 className='text-uppercase mb-4 text-center'>{message}</h1>
      </DefaultLayout>
    )
  //}
}

export default Login
