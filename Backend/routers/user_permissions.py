from typing import Optional

from fastapi import HTTPException, status
from requests import Session
from models.typer_user import RoleEnum
from models.user import User
from crud.typer_user import get_typer_user_by_id


def get_admin_user(db: Session, current_user: dict):
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)

    if not typer_user or typer_user.role != RoleEnum.admin:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to perform this action.",
        )

    return typer_user


def get_writer_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)

    if not typer_user or typer_user.role != RoleEnum.writer:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to perform this action.",
        )

    return user_id


def get_editor_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)

    if not typer_user or typer_user.role != RoleEnum.editor:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to perform this action.",
        )

    return user_id


def get_viewer_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)
    if not typer_user or (typer_user.role not in [RoleEnum.viewer, RoleEnum.writer, RoleEnum.editor, RoleEnum.admin]):
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to perform this action.",
        )

    return user_id
