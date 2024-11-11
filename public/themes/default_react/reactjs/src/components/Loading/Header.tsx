import Placeholder from 'react-bootstrap/Placeholder'

const LoadingHeader = () => {
  return (
    <>
      <div style={{ minHeight: 90 }} aria-hidden='true'>
        <Placeholder xs={12} bg='light' />
      </div>
    </>
  )
}

export default LoadingHeader
