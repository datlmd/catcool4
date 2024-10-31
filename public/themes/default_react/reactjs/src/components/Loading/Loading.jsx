import Spinner from 'react-bootstrap/Spinner';

const Loading = () => {
  return (
    <>
      <div className='centredDiv'>
        <Spinner size='lg' type='grow' color='dark' />
      </div>
    </>
  );
};

export default Loading;
