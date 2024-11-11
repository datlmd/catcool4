import { FC } from 'react'

import './assets/styles/App.css'

const App_BK: FC = () => {
  const fullname: string = 'Dư Thanh Được 44'
  console.log(fullname)
  return (
    <div className='wrap'>
      <h1>{fullname}</h1>
      <h2>Bài viết được viết tại blog {process.env.HOST}</h2>
    </div>
  )
}

export default App_BK
