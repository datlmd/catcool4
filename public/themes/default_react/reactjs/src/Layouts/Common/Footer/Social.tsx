import { ILayout } from '../../../types/index'
import { Link } from '@inertiajs/inertia-react'

const Social = ({ data }: ILayout) => {
    return (
        <>
            <h5 className='social-icon-title'>{data.text_follow}</h5>

            <ul className='social-icon-list social-icons'>
                {data.social_facebook_link && (
                    <li className='social-icons-facebook'>
                        <Link href={data.social_facebook_link} target='_blank' title='Facebook'>
                            <i className='fab fa-facebook-f'></i>
                        </Link>
                    </li>
                )}

                {data.social_twitter_link && (
                    <li className='social-icons-twitter'>
                        <Link href={data.social_twitter_link} target='_blank' title='Twitter'>
                            <i className='fab fa-twitter'></i>
                        </Link>
                    </li>
                )}

                {data.social_tiktok_link && (
                    <li className='social-icons-tiktok'>
                        <Link href={data.social_tiktok_link} target='_blank' title='Tiktok'>
                            <i className='fab fa-tiktok'></i>
                        </Link>
                    </li>
                )}

                {data.social_linkedin_link && (
                    <li className='social-icons-linkedin'>
                        <Link href={data.social_linkedin_link} target='_blank' title='Linkedin'>
                            <i className='fab fa-linkedin-in'></i>
                        </Link>
                    </li>
                )}

                {data.social_youtube_link && (
                    <li className='social-icons-youtube'>
                        <Link href={data.social_youtube_link} target='_blank' title='Youtube'>
                            <i className='fab fa-youtube'></i>
                        </Link>
                    </li>
                )}

                {data.social_instagram_link && (
                    <li className='social-icons-instagram'>
                        <Link href={data.social_instagram_link} target='_blank' title='Instagram'>
                            <i className='fab fa-instagram'></i>
                        </Link>
                    </li>
                )}

                {data.social_pinterest_link && (
                    <li className='social-icons-pinterest'>
                        <Link href={data.social_pinterest_link} target='_blank' title='Pinterest'>
                            <i className='fab fa-pinterest'></i>
                        </Link>
                    </li>
                )}
            </ul>
        </>
    )
}

export default Social
