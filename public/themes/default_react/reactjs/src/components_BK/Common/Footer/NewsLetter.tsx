import { ILayout } from 'src/store/types'

const NewsLetter = ({ data }: ILayout) => {
  return (
    <>
      <div id='newsletter_content' className='newsletter-content text-center'>
        <h5 className='mb-2 text-white'>{unescape(data.text_newsletter)}</h5>
        <p className='mb-2'>{data.text_newsletter_description}</p>
        <div className='alert alert-danger d-none' id='newsletterError'></div>

        <form id='newsletter_form' action='php/newsletter-subscribe.php' method='POST' className='mw-100'>
          <div className='input-group input-group-rounded'>
            <input
              className='form-control bg-light px-3 fs-5'
              placeholder={data.text_subscribe_email}
              name='newsletterEmail'
              id='newsletterEmail'
              type='text'
            />
            <button className='input-group-text bg-secondary py-3 px-3' type='submit'>
              <strong>{data.button_subscribe}</strong>
            </button>
          </div>
        </form>
      </div>
    </>
  )
}

export default NewsLetter
