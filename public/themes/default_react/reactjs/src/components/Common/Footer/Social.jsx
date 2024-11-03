const Social = (props) => {
  return (
    <>
      <h5 className="social-icon-title">{props.text_follow}</h5>

      <ul className="social-icon-list social-icons">
          {props.social_facebook_link && (
              <li className="social-icons-facebook">
                  <a href={props.social_facebook_link} target="_blank" title="Facebook">
                      <i className="fab fa-facebook-f"></i>
                  </a>
              </li>
          )}

          {props.social_twitter_link && (
              <li className="social-icons-twitter">
                  <a href={props.social_twitter_link} target="_blank" title="Twitter">
                      <i className="fab fa-twitter"></i>
                  </a>
              </li>
          )}

          {props.social_tiktok_link && (
              <li className="social-icons-tiktok">
                  <a href={props.social_tiktok_link} target="_blank" title="Tiktok">
                      <i className="fab fa-tiktok"></i>
                  </a>
              </li>
          )}

          {props.social_linkedin_link && (
              <li className="social-icons-linkedin">
                  <a href={props.social_linkedin_link} target="_blank" title="Linkedin">
                      <i className="fab fa-linkedin-in"></i>
                  </a>
              </li>
          )}

          {props.social_youtube_link && (
              <li className="social-icons-youtube">
                  <a href={props.social_youtube_link} target="_blank" title="Youtube">
                      <i className="fab fa-youtube"></i>
                  </a>
              </li>
          )}

          {props.social_instagram_link && (
              <li className="social-icons-instagram">
                  <a href={props.social_instagram_link} target="_blank" title="Instagram">
                      <i className="fab fa-instagram"></i>
                  </a>
              </li>
          )}

          {props.social_pinterest_link && (
              <li className="social-icons-pinterest">
                  <a href={props.social_pinterest_link} target="_blank" title="Pinterest">
                      <i className="fab fa-pinterest"></i>
                  </a>
              </li>
          )}

      </ul>
    </>
  );
};

export default Social;
