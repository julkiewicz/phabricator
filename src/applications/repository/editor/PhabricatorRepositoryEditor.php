<?php

final class PhabricatorRepositoryEditor
  extends PhabricatorApplicationTransactionEditor {

  public function getTransactionTypes() {
    $types = parent::getTransactionTypes();

    $types[] = PhabricatorRepositoryTransaction::TYPE_ACTIVATE;
    $types[] = PhabricatorRepositoryTransaction::TYPE_NAME;
    $types[] = PhabricatorRepositoryTransaction::TYPE_DESCRIPTION;
    $types[] = PhabricatorRepositoryTransaction::TYPE_ENCODING;
    $types[] = PhabricatorRepositoryTransaction::TYPE_DEFAULT_BRANCH;
    $types[] = PhabricatorRepositoryTransaction::TYPE_TRACK_ONLY;
    $types[] = PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE_ONLY;
    $types[] = PhabricatorRepositoryTransaction::TYPE_UUID;
    $types[] = PhabricatorRepositoryTransaction::TYPE_SVN_SUBPATH;
    $types[] = PhabricatorRepositoryTransaction::TYPE_NOTIFY;
    $types[] = PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE;
    $types[] = PhabricatorRepositoryTransaction::TYPE_REMOTE_URI;
    $types[] = PhabricatorRepositoryTransaction::TYPE_SSH_LOGIN;
    $types[] = PhabricatorRepositoryTransaction::TYPE_SSH_KEY;
    $types[] = PhabricatorRepositoryTransaction::TYPE_SSH_KEYFILE;
    $types[] = PhabricatorRepositoryTransaction::TYPE_HTTP_LOGIN;
    $types[] = PhabricatorRepositoryTransaction::TYPE_HTTP_PASS;

    $types[] = PhabricatorTransactions::TYPE_VIEW_POLICY;
    $types[] = PhabricatorTransactions::TYPE_EDIT_POLICY;

    return $types;
  }

  protected function getCustomTransactionOldValue(
    PhabricatorLiskDAO $object,
    PhabricatorApplicationTransaction $xaction) {

    switch ($xaction->getTransactionType()) {
      case PhabricatorRepositoryTransaction::TYPE_ACTIVATE:
        return $object->isTracked();
      case PhabricatorRepositoryTransaction::TYPE_NAME:
        return $object->getName();
      case PhabricatorRepositoryTransaction::TYPE_DESCRIPTION:
        return $object->getDetail('description');
      case PhabricatorRepositoryTransaction::TYPE_ENCODING:
        return $object->getDetail('encoding');
      case PhabricatorRepositoryTransaction::TYPE_DEFAULT_BRANCH:
        return $object->getDetail('default-branch');
      case PhabricatorRepositoryTransaction::TYPE_TRACK_ONLY:
        return array_keys($object->getDetail('branch-filter', array()));
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE_ONLY:
        return array_keys($object->getDetail('close-commits-filter', array()));
      case PhabricatorRepositoryTransaction::TYPE_UUID:
        return $object->getUUID();
      case PhabricatorRepositoryTransaction::TYPE_SVN_SUBPATH:
        return $object->getDetail('svn-subpath');
      case PhabricatorRepositoryTransaction::TYPE_NOTIFY:
        return (int)!$object->getDetail('herald-disabled');
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE:
        return (int)!$object->getDetail('disable-autoclose');
      case PhabricatorRepositoryTransaction::TYPE_REMOTE_URI:
        return $object->getDetail('remote-uri');
      case PhabricatorRepositoryTransaction::TYPE_SSH_LOGIN:
        return $object->getDetail('ssh-login');
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEY:
        return $object->getDetail('ssh-key');
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEYFILE:
        return $object->getDetail('ssh-keyfile');
      case PhabricatorRepositoryTransaction::TYPE_HTTP_LOGIN:
        return $object->getDetail('http-login');
      case PhabricatorRepositoryTransaction::TYPE_HTTP_PASS:
        return $object->getDetail('http-pass');
    }
  }

  protected function getCustomTransactionNewValue(
    PhabricatorLiskDAO $object,
    PhabricatorApplicationTransaction $xaction) {

    switch ($xaction->getTransactionType()) {
      case PhabricatorRepositoryTransaction::TYPE_ACTIVATE:
      case PhabricatorRepositoryTransaction::TYPE_NAME:
      case PhabricatorRepositoryTransaction::TYPE_DESCRIPTION:
      case PhabricatorRepositoryTransaction::TYPE_ENCODING:
      case PhabricatorRepositoryTransaction::TYPE_DEFAULT_BRANCH:
      case PhabricatorRepositoryTransaction::TYPE_TRACK_ONLY:
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE_ONLY:
      case PhabricatorRepositoryTransaction::TYPE_UUID:
      case PhabricatorRepositoryTransaction::TYPE_SVN_SUBPATH:
      case PhabricatorRepositoryTransaction::TYPE_REMOTE_URI:
      case PhabricatorRepositoryTransaction::TYPE_SSH_LOGIN:
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEY:
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEYFILE:
      case PhabricatorRepositoryTransaction::TYPE_HTTP_LOGIN:
      case PhabricatorRepositoryTransaction::TYPE_HTTP_PASS:
        return $xaction->getNewValue();
      case PhabricatorRepositoryTransaction::TYPE_NOTIFY:
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE:
        return (int)$xaction->getNewValue();
    }
  }

  protected function applyCustomInternalTransaction(
    PhabricatorLiskDAO $object,
    PhabricatorApplicationTransaction $xaction) {

    switch ($xaction->getTransactionType()) {
      case PhabricatorRepositoryTransaction::TYPE_ACTIVATE:
        $object->setDetail('tracking-enabled', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_NAME:
        $object->setName($xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_DESCRIPTION:
        $object->setDetail('description', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_DEFAULT_BRANCH:
        $object->setDetail('default-branch', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_TRACK_ONLY:
        $object->setDetail(
          'branch-filter',
          array_fill_keys($xaction->getNewValue(), true));
        break;
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE_ONLY:
        $object->setDetail(
          'close-commits-filter',
          array_fill_keys($xaction->getNewValue(), true));
        break;
      case PhabricatorRepositoryTransaction::TYPE_UUID:
        $object->setUUID($xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_SVN_SUBPATH:
        $object->setDetail('svn-subpath', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_NOTIFY:
        $object->setDetail('herald-disabled', (int)!$xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_AUTOCLOSE:
        $object->setDetail('disable-autoclose', (int)!$xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_REMOTE_URI:
        $object->setDetail('remote-uri', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_SSH_LOGIN:
        $object->setDetail('ssh-login', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEY:
        $object->setDetail('ssh-key', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_SSH_KEYFILE:
        $object->setDetail('ssh-keyfile', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_HTTP_LOGIN:
        $object->setDetail('http-login', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_HTTP_PASS:
        $object->setDetail('http-pass', $xaction->getNewValue());
        break;
      case PhabricatorRepositoryTransaction::TYPE_ENCODING:
        // Make sure the encoding is valid by converting to UTF-8. This tests
        // that the user has mbstring installed, and also that they didn't type
        // a garbage encoding name. Note that we're converting from UTF-8 to
        // the target encoding, because mbstring is fine with converting from
        // a nonsense encoding.
        $encoding = $xaction->getNewValue();
        if (strlen($encoding)) {
          try {
            phutil_utf8_convert('.', $encoding, 'UTF-8');
          } catch (Exception $ex) {
            throw new PhutilProxyException(
              pht(
                "Error setting repository encoding '%s': %s'",
                $encoding,
                $ex->getMessage()),
              $ex);
          }
        }
        $object->setDetail('encoding', $encoding);
        break;
    }
  }

  protected function applyCustomExternalTransaction(
    PhabricatorLiskDAO $object,
    PhabricatorApplicationTransaction $xaction) {
    return;
  }

  protected function mergeTransactions(
    PhabricatorApplicationTransaction $u,
    PhabricatorApplicationTransaction $v) {

    $type = $u->getTransactionType();
    switch ($type) {
    }

    return parent::mergeTransactions($u, $v);
  }

  protected function transactionHasEffect(
    PhabricatorLiskDAO $object,
    PhabricatorApplicationTransaction $xaction) {

    $old = $xaction->getOldValue();
    $new = $xaction->getNewValue();

    $type = $xaction->getTransactionType();
    switch ($type) {

    }

    return parent::transactionHasEffect($object, $xaction);
  }

}
