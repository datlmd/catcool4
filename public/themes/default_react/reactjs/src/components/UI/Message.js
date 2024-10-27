import Alert from 'react-bootstrap/Alert';
import Button from 'react-bootstrap/Button';

function Message({message, isShow, type}) {
  return isShow ? (
    <>
      <Alert key={type} variant={type} onClose={() => isShow} dismissible>
        <Alert.Heading>Oh snap! You got an error!</Alert.Heading>
        {Array.isArray(message) ? (
          message.map(mess => 
            <p key={mess}><i className="fas fa-check-circle me-2"></i>{mess}</p>
          )
        ) : (
          <p key={message}><i className="fas fa-check-circle me-2"></i>{message}</p>
        )}
      </Alert>
    </>
  ) : (
     <></>
  );
}

export default Message;
