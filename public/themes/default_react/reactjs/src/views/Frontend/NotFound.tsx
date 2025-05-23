import { Link } from 'react-router-dom'

export default function PageNotFound() {
  return (
    <>
      <div className='wrap'>
        <h1>404 - Page Not Found</h1>
        <p>Could not find the page you were looking for.</p>
        <Link to={'/'}>Return to Dashboard</Link>
      </div>
    </>
  )
}
