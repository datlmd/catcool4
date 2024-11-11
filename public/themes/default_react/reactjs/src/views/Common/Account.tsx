import { Link } from "react-router-dom";

const Account = (props: any) => {
  return (
    <>
      <div className="list-group mb-3">
        {!props.logged && (
          <>
            <Link to={props.login} className="list-group-item">{props.text_login}</Link>
            <Link to={props.register} className="list-group-item">{props.text_register}</Link>
            <Link to={props.logforgottenin} className="list-group-item">{props.text_forgotten}</Link>
          </>
        )}
        
        <Link to={props.profile} className="list-group-item">{props.text_profile}</Link>
        
        {props.logged && (
          <>
            <Link to={props.edit} className="list-group-item">{props.text_account_edit}</Link>
            <Link to={props.password} className="list-group-item">{props.text_password}</Link>
          </>
        )}
        
        <Link to={props.address} className="list-group-item">{props.text_address}</Link>
        <Link to={props.wishlist} className="list-group-item">{props.text_wishlist}</Link>
        <Link to={props.order} className="list-group-item">{props.text_order}</Link>
        <Link to={props.download} className="list-group-item">{props.text_download}</Link>

        <Link to={props.reward} className="list-group-item">{props.text_reward}</Link>
        <Link to={props.return} className="list-group-item">{props.text_return}</Link>
        <Link to={props.transaction} className="list-group-item">{props.text_transaction}</Link>
        <Link to={props.newsletter} className="list-group-item">{props.text_newsletter}</Link>
        <Link to={props.subscription} className="list-group-item">{props.text_subscription}</Link>

        {!props.logged 
          && <Link to={props.logout} className="list-group-item">{props.text_logout}</Link>
        }
      </div>
    </>
  );
};

export default Account;
