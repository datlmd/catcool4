import { useEffect } from 'react'
import { useAppSelector, useAppDispatch } from '../../store/hooks'
import { loadAbout, aboutData, aboutStatus } from '../../store/modules/about/aboutSlice'

const AboutView = ({ callbackLayout }: { callbackLayout: object }) => {
  const dispatch = useAppDispatch()
  const status = useAppSelector(aboutStatus)
  const data = useAppSelector(aboutData)

  useEffect(() => {
    if (status === 'idle') {
      dispatch(loadAbout())
    }
    if (data.layouts && data.layouts != undefined) {
      callbackLayout(data.layouts)
    }
  }, [dispatch, status, data, callbackLayout])

  return (
    <>
      {status}
      <h1>About US</h1>
    </>
  )
}

export default AboutView
