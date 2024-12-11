'use strict'

import { useEffect, useState, useContext } from 'react'
import { useNavigate } from "react-router-dom";
import LoadingContent from '../../components/Loading/Content'
import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { loadProfile, pageData, pageStatus } from '../../store/modules/account/profileSlice'
import { PageContext } from '../../contexts/Page'

const ProfileView = ({ callbackLayout }: { callbackLayout: void }) => {
  const pageContext = useContext(PageContext)
  const dispatch = useAppDispatch()
  const status = useAppSelector(pageStatus)
  const data = useAppSelector(pageData)
  const navigate = useNavigate();

  useEffect(() => {
    if (status === 'idle') {
      dispatch(loadProfile())
    }
    
    if (data.redirect_url && data.redirect_url != undefined) {
      //window.location.replace(data.redirect_url)
      navigate(data.redirect_url)
      console.log(data.redirect_url)
    }

    if (data.layouts && data.layouts != undefined) {
      callbackLayout(data.layouts)
    }
  }, [dispatch, status, data, callbackLayout])

  if (data.status === 'pending') {
    return <LoadingContent />
  } else {
    return (
      <>
        <h1 className='text-uppercase mb-4 text-center'>{data.text_my_account}</h1>
        <div className='mx-auto' style={{ maxWidth: '500px' }}>
          fdfdf
        </div>
      </>
    )
  }
}

export default ProfileView
