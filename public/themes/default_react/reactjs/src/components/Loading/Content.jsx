import Placeholder from "react-bootstrap/Placeholder";

const LoadingContent = () => {
  return (
    <>
      <h1 aria-hidden="true">
        <Placeholder xs={6} bg="light" />
      </h1>
      <div aria-hidden="true">
        <Placeholder xs={12} bg="light" />
      </div>
      <div aria-hidden="true">
        <Placeholder xs={12} bg="light" />
      </div>
      <div aria-hidden="true">
        <Placeholder xs={12} bg="light" />
      </div>
    </>
  );
};

export default LoadingContent;
