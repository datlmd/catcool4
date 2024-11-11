import { Link } from "react-router-dom";
import { ILayout } from "src/store/types";

const Account = ({data}: ILayout) => {
  return (
    <>
      <div className="list-group mb-3">
        {!data.logged && (
          <>
            <Link to={data.login} className="list-group-item">{data.text_login}</Link>
            <Link to={data.register} className="list-group-item">{data.text_register}</Link>
            <Link to={data.logforgottenin} className="list-group-item">{data.text_forgotten}</Link>
          </>
        )}
        
        <Link to={data.profile} className="list-group-item">{data.text_profile}</Link>
        
        {data.logged && (
          <>
            <Link to={data.edit} className="list-group-item">{data.text_account_edit}</Link>
            <Link to={data.password} className="list-group-item">{data.text_password}</Link>
          </>
        )}
        
        <Link to={data.address} className="list-group-item">{data.text_address}</Link>
        <Link to={data.wishlist} className="list-group-item">{data.text_wishlist}</Link>
        <Link to={data.order} className="list-group-item">{data.text_order}</Link>
        <Link to={data.download} className="list-group-item">{data.text_download}</Link>

        <Link to={data.reward} className="list-group-item">{data.text_reward}</Link>
        <Link to={data.return} className="list-group-item">{data.text_return}</Link>
        <Link to={data.transaction} className="list-group-item">{data.text_transaction}</Link>
        <Link to={data.newsletter} className="list-group-item">{data.text_newsletter}</Link>
        <Link to={data.subscription} className="list-group-item">{data.text_subscription}</Link>

        {!data.logged 
          && <Link to={data.logout} className="list-group-item">{data.text_logout}</Link>
        }
      </div>
    </>
  );
};

export default Account;
