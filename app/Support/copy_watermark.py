import sys
from pathlib import Path

import fitz


def add_watermark(input_pdf, output_pdf, label):
    doc = fitz.open(input_pdf)
    text = (label or "COPIA SIMPLE").upper()

    for page in doc:
        rect = page.rect
        font_size = max(34, min(rect.width, rect.height) * 0.075)

        page.insert_text(
            fitz.Point(rect.width - 34, rect.height - 56),
            text,
            fontsize=font_size,
            fontname="helv",
            color=(0.72, 0.72, 0.72),
            rotate=90,
            overlay=True,
        )

        page.insert_textbox(
            fitz.Rect(42, rect.height - 38, rect.width - 42, rect.height - 18),
            "Copia emitida desde Casillero Digital de Transparencia - CDT",
            fontsize=7.5,
            fontname="helv",
            color=(0.25, 0.25, 0.25),
            align=1,
            overlay=True,
        )

    Path(output_pdf).parent.mkdir(parents=True, exist_ok=True)
    doc.save(output_pdf, garbage=4, deflate=True)
    doc.close()


if __name__ == "__main__":
    if len(sys.argv) < 4:
        raise SystemExit("Usage: copy_watermark.py input_pdf output_pdf watermark_label")

    add_watermark(sys.argv[1], sys.argv[2], sys.argv[3])
