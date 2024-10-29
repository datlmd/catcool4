import { useState } from "react";
import { Dropdown, Collapse, Button } from "react-bootstrap";

export default function Language({ language, type }) {
  const [open, setOpen] = useState(false);

  const languageItem =
    language.list &&
    language.list.map((value) => {
      if (type && type == "collapse") {
        return (
          <li key={value.code}>
            <a href={value.href}>
              <i className={value.icon}></i> {value.text_language}
            </a>
          </li>
        );
      } else {
        return (
          <Dropdown.Item key={value.code} href={value.href}>
            <i className={value.icon}></i> {value.text_language}
          </Dropdown.Item>
        );
      }
    });

  if (type && type == "collapse") {
    return (
      <>
        <Button
          onClick={() => setOpen(!open)}
          aria-controls="nav-collapse-account-top"
          aria-expanded={open}
          className="nav-link icon-collapse collapsed">
          <i className={language.info.icon}></i>{" "}
          <span className="d-none d-md-inline">
            {language.info.text_language}
          </span>
        </Button>
        <Collapse in={open}>
          <div
            id="nav-collapse-account-top"
            className="collapse multi-collapse">
            <ul className="list-unstyled">{languageItem}</ul>
          </div>
        </Collapse>
      </>
    );
  } else {
    return (
      <>
        <Dropdown align="end">
          <Dropdown.Toggle
            as="a"
            className="nav-link dropdown-toggle"
            id="nav-dropdown-account-top">
            <i className={language.info.icon}></i>{" "}
            <span className="d-none d-md-inline">
              {language.info.text_language}
            </span>
          </Dropdown.Toggle>
          <Dropdown.Menu>{languageItem}</Dropdown.Menu>
        </Dropdown>
      </>
    );
  }
}
