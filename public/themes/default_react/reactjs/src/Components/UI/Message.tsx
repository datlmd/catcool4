import Alert from 'react-bootstrap/Alert'
import { IMessageInfo } from 'src/store/types'

function Message({ message, isShow, type }: IMessageInfo) {
    if (!isShow) {
        return <></>
    }

    function iType(type: string) {
        if (type == 'danger' || type == 'info') {
            return <i className='fas fa-exclamation-circle me-2'></i>
        } else if (type == 'success') {
            return <i className='fas fa-check-circle me-2'></i>
        } else {
            return <></>
        }
    }

    if (typeof message === 'string') {
        return (
            <>
                <Alert key={type} variant={type} onClose={() => isShow} dismissible>
                    {/* <Alert.Heading>Oh snap! You got an error!</Alert.Heading> */}
                    <p key={message}>
                        {iType(type)}
                        <span dangerouslySetInnerHTML={{ __html: message }}></span>
                    </p>
                </Alert>
            </>
        )
    } else {
        const messageItem = Object.values(message).map((item) => {
            return (
                <p key={item}>
                    {iType(type)}
                    <span dangerouslySetInnerHTML={{ __html: item }}></span>
                </p>
            )
        })

        return (
            <>
                <Alert key={type} variant={type} onClose={() => isShow} dismissible>
                    {messageItem}
                </Alert>
            </>
        )
    }
}

export default Message
