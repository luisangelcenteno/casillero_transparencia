import sys
from pathlib import Path

import fitz
from PIL import Image, ImageChops


def prepare_signature(signature_file):
    image_path = Path(signature_file)
    if not image_path.exists() or image_path.suffix.lower() not in [".png", ".jpg", ".jpeg"]:
        return signature_file

    image = Image.open(image_path).convert("RGBA")
    white_bg = Image.new("RGBA", image.size, (255, 255, 255, 255))
    diff_box = ImageChops.difference(image, white_bg).getbbox()
    alpha_box = image.getchannel("A").getbbox()
    box = diff_box or alpha_box

    if not box:
        return signature_file

    left, top, right, bottom = box
    pad = 8
    box = (
        max(left - pad, 0),
        max(top - pad, 0),
        min(right + pad, image.width),
        min(bottom + pad, image.height),
    )

    cropped = image.crop(box)
    pixels = cropped.load()
    for y in range(cropped.height):
        for x in range(cropped.width):
            r, g, b, a = pixels[x, y]
            if r > 240 and g > 240 and b > 240:
                pixels[x, y] = (255, 255, 255, 0)

    output = image_path.with_name(image_path.stem + "_recortada.png")
    cropped.save(output)
    return str(output)


def stamp_pdf(input_pdf, signature_file, output_pdf, judge_name, judge_role):
    doc = fitz.open(input_pdf)
    prepared_signature = prepare_signature(signature_file)

    for page in doc:
        rect = page.rect
        stamp = fitz.Rect(32, rect.height - 132, 285, rect.height - 24)

        image_path = Path(prepared_signature)
        if image_path.exists() and image_path.suffix.lower() in [".png", ".jpg", ".jpeg"]:
            image_rect = fitz.Rect(stamp.x0 + 10, stamp.y0 + 4, stamp.x1 - 10, stamp.y0 + 82)
            page.insert_image(image_rect, filename=str(image_path), keep_proportion=True, overlay=True)

        page.draw_rect(stamp, color=(0, 0, 0), width=0.8, overlay=True)
        page.insert_textbox(
            fitz.Rect(stamp.x0 + 8, stamp.y0 + 68, stamp.x1 - 8, stamp.y0 + 84),
            judge_name,
            fontsize=9.2,
            fontname="helv",
            color=(0, 0, 0),
            align=1,
            overlay=True,
        )
        page.insert_textbox(
            fitz.Rect(stamp.x0 + 8, stamp.y0 + 84, stamp.x1 - 8, stamp.y1 - 4),
            f"{judge_role}\nFirma digital aplicada en todas las hojas.",
            fontsize=6.2,
            fontname="helv",
            color=(0, 0, 0),
            align=1,
            overlay=True,
        )

    Path(output_pdf).parent.mkdir(parents=True, exist_ok=True)
    doc.save(output_pdf, garbage=4, deflate=True)
    doc.close()


if __name__ == "__main__":
    if len(sys.argv) < 6:
        raise SystemExit("Usage: pdf_signer.py input_pdf signature_file output_pdf judge_name judge_role")

    stamp_pdf(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5])
