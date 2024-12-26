export default function Loading() {
  return (
    <>
      <div className='loading'>
        <div className='spinner-grow text-primary' style={{width: '3rem', height: '3rem'}} role='status'></div>
      </div>
      {/* <div className='loading'>
        <Spinner animation='border' variant='secondary' />
      </div> */}
    </>
  )
}
